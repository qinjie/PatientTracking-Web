<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Button */

$this->title = 'Update Button: ' . $model->residentName;
$this->params['breadcrumbs'][] = ['label' => 'Buttons', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->residentName, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="button-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'items1' => $items1,
    ]) ?>

</div>
