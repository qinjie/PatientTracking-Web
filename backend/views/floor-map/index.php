<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FloorMapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Floor Maps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="floor-map-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Floor Map', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'floor_id',
                'value' => 'floorName'
            ],
            'file_type',
            'file_name',
            'file_ext',
            // 'file_path',
            // 'thumbnail_path',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
