<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ButtonHistory */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Button Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="button-history-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'tagid',
            'created_at',
        ],
    ]) ?>

</div>
