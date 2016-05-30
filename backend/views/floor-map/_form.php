<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FloorMap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="floor-map-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'floor_id')->widget(\kartik\select2\Select2::classname(), [
        'data' => $items1,
        'options' => ['placeholder' => 'Select a floor ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'file')->widget(\kartik\file\FileInput::className(),
        [
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => [
                'showUpload' => false,
            ]
        ]
    ) ?>

<!--    --><?//= $form->field($model, 'thumbnail')->widget(\kartik\file\FileInput::className(),
//        [
//            'options' => ['accept' => 'image/*'],
//            'pluginOptions' => [
//                'showUpload' => false,
//            ]  ]
//    ) ?>

    <?= $form->field($model, 'file_type')->textInput(['maxlength' => true])->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'file_name')->textInput(['maxlength' => true])->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'file_ext')->textInput(['maxlength' => true])->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'file_path')->textInput(['maxlength' => true])->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'thumbnail_path')->textInput(['maxlength' => true])->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'created_at')->textInput()->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'updated_at')->textInput()->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
