<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Location */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="location-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'resident_id')->widget(Select2::classname(), [
        'data' => $items1,
        'options' => ['placeholder' => 'Select a resident ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'user_id')->widget(Select2::classname(), [
        'data' => $items3,
        'options' => ['placeholder' => 'Select a user ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->hint("You should choose either a Resident or a User only"); ?>

    <?= $form->field($model, 'floor_id')->widget(Select2::classname(), [
        'data' => $items2,
        'options' => ['placeholder' => 'Select a floor ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'coorx')->textInput(['readonly' => !$model->isNewRecord]) ?>

    <?= $form->field($model, 'coory')->textInput(['readonly' => !$model->isNewRecord]) ?>

    <?= $form->field($model, 'zone')->textInput() ?>

    <?= $form->field($model, 'outside')->textInput() ?>

    <?= $form->field($model, 'azimuth')->textInput() ?>

    <?= $form->field($model, 'speed')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
