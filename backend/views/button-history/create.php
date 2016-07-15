<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ButtonHistory */

$this->title = 'Create Button History';
$this->params['breadcrumbs'][] = ['label' => 'Button Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="button-history-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
