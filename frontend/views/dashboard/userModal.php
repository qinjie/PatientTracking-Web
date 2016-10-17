<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->username;
$file_path = (new \common\models\CommonFunction())->getUserFile($id);
?>
<div class="user-view">

    <h1><img height="120" width="120" src="../../../backend/web/<?=$file_path?>">&nbsp;<?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'roleName',
            'email',
        ],
    ]) ?>

</div>
