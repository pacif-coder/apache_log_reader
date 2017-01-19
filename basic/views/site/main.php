<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */

$this->title = 'Логи Apache';
?>

<div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_search', ['searchModel' => $searchModel]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        #'filterModel' => $searchModel,

        # 'emptyCell' => '-',
        'columns' => [
            [
                'attribute' => 'date',
                'contentOptions' => ['class' => 'no-wrap'],
                'format' => 'raw',
            ],

            'method',

            'host',
            [
                'attribute' => 'url',
                'format' => 'url',
            ],

            [
                'attribute' => 'referer',
                'format' => 'url',
            ],

            'code',
            'agent',
            [
                'attribute' => 'bytes',
                'format' => 'shortsize',
            ],
        ]
    ]); ?>

</div>
