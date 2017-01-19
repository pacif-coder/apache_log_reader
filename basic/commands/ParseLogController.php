<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\base\InvalidConfigException;
use app\models\ApacheLog;
use app\models\ApacheLogLastpos;

class ParseLogController extends Controller
{
    const DATE_REG = '/^(?P<day>\d+)\/(?P<month>\w+)\/(?P<year>\d+):(?P<time>[\d\:]+)/';

    public  $defaultAction = 'parse';

    /**
     * 
     */
    public function actionParse()
    {
        $log_file = Yii::$app->params['log_file'];
        
        if (!file_exists($log_file)) {
            throw new InvalidConfigException('File "' . $log_file . '" is not exist');
        }

        $logLastPos = ApacheLogLastpos::findOne($log_file);
        if (!$logLastPos) {
            $logLastPos = new ApacheLogLastpos();
            $logLastPos->path = $log_file;
            $logLastPos->pos = 0;
        }

        $handle = fopen($log_file, 'r');
        fseek($handle, $logLastPos->pos);
        $buffer = fread($handle, filesize($log_file));
        $logLastPos->pos = ftell($handle);
        fclose($handle);

        if (!$buffer) {
            print("Нет новых записей в логах для перенесения в базу данных.\r\n");
            return;
        }

        $i = 0;
        $matches = [];
        $reg = Yii::$app->params['log_parse_reg'];
        preg_match_all($reg, $buffer, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            // Преобразовываем дату из Apache вида '17/Jan/2017:16:39:01'
            // в стандартную для MySql '2017-01-17 16:39:01'
            $date = $match['date'];
            preg_match_all(self::DATE_REG, $date, $tmp, PREG_SET_ORDER);
            $date = $tmp[0]['year'] . '-' . $tmp[0]['month'] . '-' . $tmp[0]['day'] . ' ' . $tmp[0]['time'];
            $match['date'] = date('Y-m-d H:i:s', strtotime($date));

            $match['referer'] = '-' === $match['referer']? null : $match['referer'];

            $model = new ApacheLog();
            $model->attributes = $match;
            $model->save();

            $i++;
        }

        $logLastPos->save();

        print("В базу данных перенесено " . $i . " записей из лога. \r\n");
    }
}
