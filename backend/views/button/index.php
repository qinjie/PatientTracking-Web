<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ButtonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Buttons';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="button-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Button', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'tagid:ntext',
            'created_at',
            'residentName',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
