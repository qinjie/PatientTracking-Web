<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\ResidentLocation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="resident-location-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'resident_id')->widget(Select2::classname(), [
        'data' => $items1,
        'options' => ['placeholder' => 'Select a resident ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'floor_id')->widget(Select2::classname(), [
        'data' => $items2,
        'options' => ['placeholder' => 'Select a floor ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'coorx')->textInput(['readonly' => !$model->isNewRecord]) ?>

    <?= $form->field($model, 'coory')->textInput(['readonly' => !$model->isNewRecord]) ?>

    <?= $form->field($model, 'outside')->textInput() ?>

    <?= $form->field($model, 'azimuth')->textInput() ?>

    <?= $form->field($model, 'speed')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
