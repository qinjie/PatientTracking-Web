<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\QuuppaTagInfo */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Quuppa Tag Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quuppa-tag-info-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Create', ['create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'tagId',
            'name',
            'color',
            'lastPacketTS',
            'acceleration',
            'accelerationTS',
            'batteryVoltage',
            'batteryVoltageTS',
            'batteryAlarm',
            'batteryAlarmTS',
            'buttonState',
            'buttonStateTS',
            'tagState',
            'tagStateTS',
            'tagStateTransitionStatus',
            'tagStateTransitionStatusTS',
            'triggerCount',
            'triggerCountTS',
            'ioStates',
            'ioStatesTS',
            'rssi',
            'rssiLocator',
            'rssiLocatorCoords',
            'rssiCoordinateSystemId',
            'rssiCoordinateSystemName',
            'rssiTS',
            'txRate',
            'txRateTS',
            'txPower',
            'txPowerTS',
            'lastAreaId',
            'lastAreaName',
            'lastAreaTS',
            'zones',
            'custom',
            'customTS',
            'accelerationX',
            'accelerationY',
            'accelerationZ',
            'rssiLocatorCoordX',
            'rssiLocatorCoordY',
            'rssiLocatorCoordZ',
            'created_at',
        ],
    ]) ?>

</div>
