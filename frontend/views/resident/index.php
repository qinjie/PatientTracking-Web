<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ResidentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $roleArray array */

$this->title = 'Residents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resident-index">
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
                'attribute' => 'fullName',
                'value'=>function ($data) {
                    return Html::a(Html::encode($data->fullName),'resident/view?id='.$data->id);}
            ],
            'nric',
            'gender',
            'birthday',
            [
                'attribute'=>'lastFloorId',
                'value'=>'lastFloor',
                'filter'=>$roleArray,
            ],
            // 'remark',
            // 'lastmodified',
        ],
    ]); ?>
</div>
