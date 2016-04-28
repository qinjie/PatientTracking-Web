<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Marker */

$this->title = 'Update Marker: ' . $model->label;
$this->params['breadcrumbs'][] = ['label' => 'Markers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="marker-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'items1' => $items1,
    ]) ?>

</div>
