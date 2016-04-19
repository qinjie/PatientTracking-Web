<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\QuuppaTagPosition */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quuppa-tag-position-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tagId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'positionTS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'smoothedPosition')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'positionAccuracy')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'areaId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'areaName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'zones')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coordinateSystemId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coordinateSystemName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'covarianceMatrix')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'positionX')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'positionY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'positionZ')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'smoothedPositionX')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'smoothedPositionY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'smoothedPositionZ')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
