<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Tag */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tag-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tagid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'resident_id')->widget(Select2::classname(), [
        'data' => $items1,
        'options' => ['placeholder' => 'Select a resident ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'user_id')->widget(Select2::classname(), [
        'data' => $items2,
        'options' => ['placeholder' => 'Select a resident ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->hint("You should choose either a Resident or a User only"); ?>

    <?= $form->field($model, 'status')->widget(\kartik\checkbox\CheckboxX::className(), [
        'pluginOptions'=>['threeState'=>false]
    ]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
