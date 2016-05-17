<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\QuuppaTagPosition */

$this->title = 'Update Quuppa Tag Position: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Quuppa Tag Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="quuppa-tag-position-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>