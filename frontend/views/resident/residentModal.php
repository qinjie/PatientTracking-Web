<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonFunction;

/* @var $this yii\web\View */
/* @var $model common\models\Resident */

$this->title = $model->fullName;
$this->params['breadcrumbs'][] = ['label' => 'Residents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$file_path = (new CommonFunction())->getResidentFile($id);
?>
<div class="resident-view">

    <h1><img height="120" width="120" src="../../../backend/web/<?=$file_path?>">&nbsp;<?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fullName',
            'nric',
            'gender',
            'birthday',
            [
                'label' => 'Next-of-kin',
                'format' => 'raw',
                'value' => (new CommonFunction())->getNextofkinList($model->id),
            ],
            'contact',
            'lastFloor',
            'lastTime',
            'remark',
        ],
    ]) ?>

</div>
