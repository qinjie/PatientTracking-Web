<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Marker */

$this->title = 'Create Marker';
$this->params['breadcrumbs'][] = ['label' => 'Markers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marker-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
