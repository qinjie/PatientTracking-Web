<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LocationHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Location Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="location-history-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php
        if (Yii::$app->user->identity->role == \common\models\User::ROLE_MASTER)
        {
            echo "<p align=\"right\">
                    ".Html::a('Clear all data', ['delete', '' => ''], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to clear all location data?',
                            'method' => 'post',
                        ],
                    ])
                ."</p>";
        }
    ?>
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
            'created_at',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {delete}'],
        ],
    ]); ?>
</div>
