<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\QuuppaTagPositionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quuppa Tag Positions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quuppa-tag-position-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Quuppa Tag Position', ['create'], ['class' => 'btn btn-success']) ?>
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
            'positionTS',
            // 'position',
            // 'smoothedPosition',
            // 'positionAccuracy',
            // 'areaId',
            // 'areaName',
            // 'zones',
            // 'coordinateSystemId',
            // 'coordinateSystemName',
            // 'covarianceMatrix',
            // 'positionX',
            // 'positionY',
            // 'positionZ',
            // 'smoothedPositionX',
            // 'smoothedPositionY',
            // 'smoothedPositionZ',
            // 'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
