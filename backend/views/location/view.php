<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Floor;

/* @var $this yii\web\View */
/* @var $model common\models\ResidentLocation */

$this->title = 'Location of '.$model->residentName;
$this->params['breadcrumbs'][] = ['label' => 'Resident Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resident-location-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
