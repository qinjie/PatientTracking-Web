<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\FloorMap */

$this->title = 'Update Floor Map: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Floor Maps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="floor-map-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
