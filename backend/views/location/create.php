<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Location */

$this->title = 'Create Location';
$this->params['breadcrumbs'][] = ['label' => 'Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="location-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'items1' => $items1,
        'items2' => $items2,
        'items3' => $items3,
    ]) ?>

</div>
