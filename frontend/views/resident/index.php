<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Floor;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ResidentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Residents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resident-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'fullName',
            'nric',
            'gender',
            'birthday',
            [
                'label' => 'Floor',
                'value' => 'floor',
            ],
            // 'contact',
            // 'remark',
            // 'lastmodified',
        ],
    ]); ?>
</div>
