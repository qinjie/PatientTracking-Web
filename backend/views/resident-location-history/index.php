<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ResidentLocationHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Resident Location Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resident-location-history-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'tagid',
            'coorx',
            'coory',
            'zone',
            [
                'attribute'=>'outside',
                'value'=>'outsideName',
                'filter'=>array(0=>"Inside", 1=>"Outside"),
            ],
            // 'azimuth',
            'speed',
            // 'created_at',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {delete}'],
        ],
    ]); ?>
</div>
