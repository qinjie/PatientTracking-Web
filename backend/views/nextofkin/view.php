<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Nextofkin */

$this->title = $model->full_Name;
$this->params['breadcrumbs'][] = ['label' => 'Nextofkins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nextofkin-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Create', ['create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
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
            'nric',
            'first_name',
            'last_name',
            'contact',
            'email:email',
            'remark',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
