<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ResidentLocationHistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="resident-location-history-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tagid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coorx')->textInput() ?>

    <?= $form->field($model, 'coory')->textInput() ?>

    <?= $form->field($model, 'zone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'outside')->textInput() ?>

    <?= $form->field($model, 'azimuth')->textInput() ?>

    <?= $form->field($model, 'speed')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
