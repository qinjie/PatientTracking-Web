<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\LocationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Locations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="location-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Create Location', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
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
                'value' => 'residentName'
            ],
            [
                'attribute' => 'user_id',
                'value' => 'userName'
            ],
            [
                'attribute' => 'floor_id',
                'value' => 'floorName'
            ],
            'coorx',
            'coory',
            'speed',
            [
                'attribute'=>'outside',
                'value'=>'outsideName',
                'filter'=>array(0=>"Inside", 1=>"Outside"),
            ],
            // 'azimuth',
            // 'created_at',
            [
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]); ?>
</div>
