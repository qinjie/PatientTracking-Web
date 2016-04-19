<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\QuuppaTagInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quuppa-tag-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tagId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastPacketTS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'acceleration')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accelerationTS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'batteryVoltage')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'batteryVoltageTS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'batteryAlarm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'batteryAlarmTS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'buttonState')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'buttonStateTS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tagState')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tagStateTS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tagStateTransitionStatus')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tagStateTransitionStatusTS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'triggerCount')->textInput() ?>

    <?= $form->field($model, 'triggerCountTS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ioStates')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ioStatesTS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rssi')->textInput() ?>

    <?= $form->field($model, 'rssiLocator')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rssiLocatorCoords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rssiCoordinateSystemId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rssiCoordinateSystemName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rssiTS')->textInput() ?>

    <?= $form->field($model, 'txRate')->textInput() ?>

    <?= $form->field($model, 'txRateTS')->textInput() ?>

    <?= $form->field($model, 'txPower')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txPowerTS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastAreaId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastAreaName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastAreaTS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'zones')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'custom')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customTS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accelerationX')->textInput() ?>

    <?= $form->field($model, 'accelerationY')->textInput() ?>

    <?= $form->field($model, 'accelerationZ')->textInput() ?>

    <?= $form->field($model, 'rssiLocatorCoordX')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rssiLocatorCoordY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rssiLocatorCoordZ')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
