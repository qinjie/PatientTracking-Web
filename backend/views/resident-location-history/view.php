<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ResidentLocationHistory */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Resident Location Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resident-location-history-view">

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
            'resident_id',
            'tagid',
            'floor_id',
            'coorx',
            'coory',
            'zone',
            'outside',
            'azimuth',
            'speed',
            'created_at',
        ],
    ]) ?>

</div>
