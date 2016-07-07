<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ResidentLocationHistorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="resident-location-history-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'tagid') ?>

    <?= $form->field($model, 'coorx') ?>

    <?php  echo $form->field($model, 'coory') ?>

    <?php  echo $form->field($model, 'zone') ?>

    <?php // echo $form->field($model, 'outside') ?>

    <?php // echo $form->field($model, 'azimuth') ?>

    <?php // echo $form->field($model, 'speed') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
