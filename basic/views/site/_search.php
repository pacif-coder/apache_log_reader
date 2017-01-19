<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\datepicker\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $form yii\bootstrap\ActiveForm */

$form = ActiveForm::begin([
    'action' => '/',
    'method' => 'get',

    'fieldConfig' => [
        'options' => ['class' => 'form-group col-md-3'],
        'template' => "{label}&nbsp;{input}",
     ]
]);
?>
    <div class="row">
        <?= $form->field($searchModel, 'host')->label(true) ?>

        <?= $form->field($searchModel, 'begin')->widget(DateRangePicker::className(), [
                'attributeTo' => 'end',
                'form' => $form, // best for correct client validation
                'language' => 'ru',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
        ]); ?>

        <div class="form-group col-md-6">
            <?php
                // Грязный хак, конечно
            ?>
            <label style="display: block;">&nbsp;</label>
             <?= Html::submitButton('Искать', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
