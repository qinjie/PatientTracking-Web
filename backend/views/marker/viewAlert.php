<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AlertArea */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Alert Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alert-area-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'floor_id',
            'position',
            'pixelx',
            'pixely',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
