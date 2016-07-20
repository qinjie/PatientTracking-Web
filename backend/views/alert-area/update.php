<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AlertArea */

$this->title = 'Update Alert Area: ' . $model->floorName;
$this->params['breadcrumbs'][] = ['label' => 'Alert Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->floorName, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="alert-area-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'items1' => $items1,
    ]) ?>

</div>
