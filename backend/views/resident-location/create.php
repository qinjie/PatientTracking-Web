<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ResidentLocation */

$this->title = 'Create Resident Location';
$this->params['breadcrumbs'][] = ['label' => 'Resident Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resident-location-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'items1' => $items1,
        'items2' => $items2,
    ]) ?>

</div>
