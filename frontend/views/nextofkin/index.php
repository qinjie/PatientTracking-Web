<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\NextofkinSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Next-of-kins';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nextofkin-index">
    <div align="center">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'=>'Full Name',
                'format' => 'raw',
                'attribute' => 'full_Name',
                'value'=>function ($data) {
                    return Html::a(Html::encode($data->full_Name),'nextofkin/view?id='.$data->id);}
            ],
            'nric',
            'contact',
            'email:email',
            // 'remark',
            // 'created_at',
            // 'updated_at',

        ],
    ]); ?>
</div>
