<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ResidentRelative */

$this->title = 'Update Relationship of ' . $model->residentName;
$this->params['breadcrumbs'][] = ['label' => 'Resident Relatives', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->residentName, 'url' => ['view', 'id' => $model->id]];
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
