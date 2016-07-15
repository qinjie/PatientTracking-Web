<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AlertAreaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Alert Areas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alert-area-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Alert Area', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'floorName',
            'quuppa_id:ntext',
            'description:ntext',
            [
                'attribute'=>'status',
                'value'=>'statusName',
                'filter'=>array(1=>"Active", 0=>"Inactive"),
            ],
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
