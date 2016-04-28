<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\FloorMap */

$this->title = 'Create Floor Map';
$this->params['breadcrumbs'][] = ['label' => 'Floor Maps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="floor-map-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'items1' => $items1,
    ]) ?>

</div>
