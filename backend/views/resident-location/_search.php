<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ResidentLocationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="resident-location-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'resident_id') ?>

    <?= $form->field($model, 'floor_id') ?>

    <?= $form->field($model, 'coorx') ?>

    <?= $form->field($model, 'coory') ?>

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
