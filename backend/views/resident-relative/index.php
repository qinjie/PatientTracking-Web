<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ResidentRelativeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Resident Relatives';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resident-relative-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Resident Relative', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'resident_id',
                'value' => 'residentName'
            ],
            [
                'attribute' => 'nextofkin_id',
                'value' => 'nextofkinName'
            ],
            'relation',
            'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
