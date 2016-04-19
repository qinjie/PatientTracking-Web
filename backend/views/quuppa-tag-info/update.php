<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\QuuppaTagInfo */

$this->title = 'Update Quuppa Tag Info: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Quuppa Tag Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="quuppa-tag-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
