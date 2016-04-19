<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\NextofkinSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nextofkins';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nextofkin-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nric',
            'first_name',
            'last_name',
            'contact',
            // 'email:email',
            // 'remark',
            // 'created_at',
            // 'updated_at',

        ],
    ]); ?>
</div>
