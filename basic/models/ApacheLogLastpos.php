<?php
namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "apache_log_lastpos".
 *
 * @property string $path
 * @property integer $pos
 */
class ApacheLogLastpos extends ActiveRecord
{
    public static function tableName()
    {
        return 'apache_log_lastpos';
    }
}
