<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = "User: ".$model->username;
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'roleName',
            'lastFloor',
            'coorx',
            'coory',
            'speed',
            'azimuth',
            [
                'label' => 'Last Signal',
                'attribute' => 'lastTime',
            ],
        ],
    ]) ?>

</div>
