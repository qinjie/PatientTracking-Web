<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ResidentLocationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Resident Locations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resident-location-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'firstPageLabel' => 'First',
            'lastPageLabel' => 'Last',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'resident_id',
                'value' => 'resident.fullName'
            ],
            [
                'attribute' => 'floor_id',
                'value' => 'floor.label'
            ],
            'coorx',
            'coory',
            // 'outside',
            // 'azimuth',
            'speed',
            // 'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
