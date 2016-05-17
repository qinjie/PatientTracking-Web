<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ResidentRelative */

$this->title = 'Update Resident Relative: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Resident Relatives', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="resident-relative-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'items1' => $items1,
        'items2' => $items2,
    ]) ?>

</div>