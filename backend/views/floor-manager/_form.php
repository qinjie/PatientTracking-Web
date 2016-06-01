<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FloorManager */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="floor-manager-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'userid')->widget(\kartik\select2\Select2::classname(), [
        'data' => $items2,
        'options' => ['placeholder' => 'Select a resident ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'floorid')->widget(\kartik\select2\Select2::classname(), [
        'data' => $items1,
        'options' => ['placeholder' => 'Select a resident ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
