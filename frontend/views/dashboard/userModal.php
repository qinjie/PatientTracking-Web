<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->username;
?>
<div class="user-view">

    <h1><img height="120" width="120" src="../../web/nurse1.png">&nbsp;<?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'roleName',
            'email',
        ],
    ]) ?>

</div>
