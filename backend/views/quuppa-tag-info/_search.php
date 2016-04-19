<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\QuuppaTagInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quuppa-tag-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'tagId') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'color') ?>

    <?= $form->field($model, 'lastPacketTS') ?>

    <?php // echo $form->field($model, 'acceleration') ?>

    <?php // echo $form->field($model, 'accelerationTS') ?>

    <?php // echo $form->field($model, 'batteryVoltage') ?>

    <?php // echo $form->field($model, 'batteryVoltageTS') ?>

    <?php // echo $form->field($model, 'batteryAlarm') ?>

    <?php // echo $form->field($model, 'batteryAlarmTS') ?>

    <?php // echo $form->field($model, 'buttonState') ?>

    <?php // echo $form->field($model, 'buttonStateTS') ?>

    <?php // echo $form->field($model, 'tagState') ?>

    <?php // echo $form->field($model, 'tagStateTS') ?>

    <?php // echo $form->field($model, 'tagStateTransitionStatus') ?>

    <?php // echo $form->field($model, 'tagStateTransitionStatusTS') ?>

    <?php // echo $form->field($model, 'triggerCount') ?>

    <?php // echo $form->field($model, 'triggerCountTS') ?>

    <?php // echo $form->field($model, 'ioStates') ?>

    <?php // echo $form->field($model, 'ioStatesTS') ?>

    <?php // echo $form->field($model, 'rssi') ?>

    <?php // echo $form->field($model, 'rssiLocator') ?>

    <?php // echo $form->field($model, 'rssiLocatorCoords') ?>

    <?php // echo $form->field($model, 'rssiCoordinateSystemId') ?>

    <?php // echo $form->field($model, 'rssiCoordinateSystemName') ?>

    <?php // echo $form->field($model, 'rssiTS') ?>

    <?php // echo $form->field($model, 'txRate') ?>

    <?php // echo $form->field($model, 'txRateTS') ?>

    <?php // echo $form->field($model, 'txPower') ?>

    <?php // echo $form->field($model, 'txPowerTS') ?>

    <?php // echo $form->field($model, 'lastAreaId') ?>

    <?php // echo $form->field($model, 'lastAreaName') ?>

    <?php // echo $form->field($model, 'lastAreaTS') ?>

    <?php // echo $form->field($model, 'zones') ?>

    <?php // echo $form->field($model, 'custom') ?>

    <?php // echo $form->field($model, 'customTS') ?>

    <?php // echo $form->field($model, 'accelerationX') ?>

    <?php // echo $form->field($model, 'accelerationY') ?>

    <?php // echo $form->field($model, 'accelerationZ') ?>

    <?php // echo $form->field($model, 'rssiLocatorCoordX') ?>

    <?php // echo $form->field($model, 'rssiLocatorCoordY') ?>

    <?php // echo $form->field($model, 'rssiLocatorCoordZ') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
