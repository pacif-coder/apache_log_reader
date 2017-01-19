<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

use app\models\ApacheLog;

class ApacheLogSearch extends ApacheLog
{
    public $begin = null;
    public $end = null;

    public function rules()
    {
        return [
            [['host', 'begin', 'end'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ApacheLog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->host) {
            $query->andWhere(['like', 'host', $this->host . '%', false]);
        }

        $query->andFilterWhere(['>=', 'date', $this->begin]);

        if ($this->end) {
            $query->andWhere(['<=', 'date', $this->end . ' 23:59:59']);
        }

        return $dataProvider;
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['begin'] = $labels['date'];

        return $labels;
    }

    function formName() {
        return 'search';
    }
}
