<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MarkerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="marker-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'label') ?>

    <?= $form->field($model, 'mac') ?>

    <?= $form->field($model, 'floor_id') ?>

    <?= $form->field($model, 'position') ?>

    <?php // echo $form->field($model, 'pixelx') ?>

    <?php // echo $form->field($model, 'pixely') ?>

    <?php // echo $form->field($model, 'coorx') ?>

    <?php // echo $form->field($model, 'coory') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
