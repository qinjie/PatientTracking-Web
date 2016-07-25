<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AlertArea */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alert-area-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'floor_id')->widget(\kartik\select2\Select2::classname(), [
        'data' => $items1,
        'options' => ['placeholder' => 'Select a floor ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'quuppa_id')->textInput() ?>

    <?= $form->field($model, 'description')->textInput() ?>

    <?= $form->field($model, 'status')->widget(\kartik\checkbox\CheckboxX::className(), [
        'pluginOptions'=>['threeState'=>false]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
