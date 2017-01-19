<?php
namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "apache_log".
 *
 * @property integer $id
 * @property string $date
 * @property string $host
 * @property string $method
 * @property string $url
 * @property string $referer
 * @property integer $code
 * @property string $identity
 * @property string $user
 * @property string $agent
 * @property integer $bytes
 */
class ApacheLog extends ActiveRecord
{
    public static function tableName()
    {
        return 'apache_log';
    }

    public function rules()
    {
        return [
            [['date', 'host', 'method', 'url', 'code', 'identity', 'user', 'agent'], 'required'],
            [['date'], 'safe'],
            [['method'], 'string'],
            [['code', 'bytes'], 'integer'],
            [['host', 'url', 'referer', 'identity', 'user', 'agent'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата',
            'host' => 'Host',
            'method' => 'Метод',
            'url' => 'Адрес',
            'referer' => 'Рефер',
            'code' => 'Код ответа',
            'identity' => 'Identity',
            'user' => 'User',
            'agent' => 'Agent',
            'bytes' => 'Размер ответа',
        ];
    }
    
    public function fields()
    {
        $fields = parent::fields();

        # пропускаем служебные данные ('id') или что редко
        # заполненно валидно ('identity', 'user')
        unset($fields['id'], $fields['identity'], $fields['user']);

        return $fields;
    }
}
