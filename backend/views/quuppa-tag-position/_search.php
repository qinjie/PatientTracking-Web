<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\QuuppaTagPositionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quuppa-tag-position-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'tagId') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'color') ?>

    <?= $form->field($model, 'positionTS') ?>

    <?php // echo $form->field($model, 'position') ?>

    <?php // echo $form->field($model, 'smoothedPosition') ?>

    <?php // echo $form->field($model, 'positionAccuracy') ?>

    <?php // echo $form->field($model, 'areaId') ?>

    <?php // echo $form->field($model, 'areaName') ?>

    <?php // echo $form->field($model, 'zones') ?>

    <?php // echo $form->field($model, 'coordinateSystemId') ?>

    <?php // echo $form->field($model, 'coordinateSystemName') ?>

    <?php // echo $form->field($model, 'covarianceMatrix') ?>

    <?php // echo $form->field($model, 'positionX') ?>

    <?php // echo $form->field($model, 'positionY') ?>

    <?php // echo $form->field($model, 'positionZ') ?>

    <?php // echo $form->field($model, 'smoothedPositionX') ?>

    <?php // echo $form->field($model, 'smoothedPositionY') ?>

    <?php // echo $form->field($model, 'smoothedPositionZ') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
