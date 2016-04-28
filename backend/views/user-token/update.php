<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UserToken */

$this->title = 'Update User Token: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Tokens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-token-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'items1' => $items1,
    ]) ?>

</div>
