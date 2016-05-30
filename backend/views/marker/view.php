<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Marker */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Markers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marker-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <br>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'label',
            'mac',
            'floor_id',
            'position',
            'pixelx',
            'pixely',
            'coorx',
            'coory',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
