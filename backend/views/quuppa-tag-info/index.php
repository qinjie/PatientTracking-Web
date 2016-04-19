<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\QuuppaTagInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quuppa Tag Infos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quuppa-tag-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Quuppa Tag Info', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'tagId',
            'name',
            'color',
            'lastPacketTS',
            // 'acceleration',
            // 'accelerationTS',
            // 'batteryVoltage',
            // 'batteryVoltageTS',
            // 'batteryAlarm',
            // 'batteryAlarmTS',
            // 'buttonState',
            // 'buttonStateTS',
            // 'tagState',
            // 'tagStateTS',
            // 'tagStateTransitionStatus',
            // 'tagStateTransitionStatusTS',
            // 'triggerCount',
            // 'triggerCountTS',
            // 'ioStates',
            // 'ioStatesTS',
            // 'rssi',
            // 'rssiLocator',
            // 'rssiLocatorCoords',
            // 'rssiCoordinateSystemId',
            // 'rssiCoordinateSystemName',
            // 'rssiTS',
            // 'txRate',
            // 'txRateTS',
            // 'txPower',
            // 'txPowerTS',
            // 'lastAreaId',
            // 'lastAreaName',
            // 'lastAreaTS',
            // 'zones',
            // 'custom',
            // 'customTS',
            // 'accelerationX',
            // 'accelerationY',
            // 'accelerationZ',
            // 'rssiLocatorCoordX',
            // 'rssiLocatorCoordY',
            // 'rssiLocatorCoordZ',
            // 'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
