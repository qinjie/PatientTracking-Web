<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Floor;

/* @var $this yii\web\View */
/* @var $model backend\models\Resident */

$this->title = $model->fullName;
$this->params['breadcrumbs'][] = ['label' => 'Residents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resident-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'fullName',
            'nric',
            'gender',
            'birthday',
            [
                'label' => 'Next-of-kin',
                'format' => 'raw',
                'value' => (new Floor())->getNextofkinList($model->id),
            ],
            'contact',
            'remark',
            'lastmodified',
        ],
    ]) ?>

</div>
