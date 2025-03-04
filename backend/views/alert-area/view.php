<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AlertArea */

$this->title = $model->floorName;
$this->params['breadcrumbs'][] = ['label' => 'Alert Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alert-area-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            'floorName',
            'quuppa_id:ntext',
            'description:ntext',
            'statusName',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
