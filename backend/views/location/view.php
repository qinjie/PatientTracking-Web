<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Floor;

/* @var $this yii\web\View */
/* @var $model common\models\Location */
$array = [];
if ($model->residentName){
    $array[] = $model->residentName;
}
if ($model->userName){
    $array[] = $model->userName;
}
$name = implode($array, ', ');
$this->title = 'Location of '.$name;
$this->params['breadcrumbs'][] = ['label' => 'Resident Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="location-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'resident_id',
                'value' => $model->residentName,
            ],
            [
                'attribute' => 'user_id',
                'value' => $model->userName,
            ],
            [
                'attribute' => 'floor_id',
                'value' => $model->floorName,
            ],
            'coorx',
            'coory',
            'zone',
            [
                'attribute'=>'outside',
                'value'=>'outsideName',
                'filter'=>array(0=>"Time out", 1=>"Outside"),
            ],
            'azimuth',
            'speed',
            'created_at',
        ],
    ]) ?>

</div>
