<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Nextofkin */

$this->title = 'Update Nextofkin: ' . $model->full_Name;
$this->params['breadcrumbs'][] = ['label' => 'Nextofkins', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->full_Name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="nextofkin-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
