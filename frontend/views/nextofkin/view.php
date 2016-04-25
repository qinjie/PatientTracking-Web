<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Floor;

/* @var $this yii\web\View */
/* @var $model backend\models\Nextofkin */

$this->title = $model->full_Name;
$this->params['breadcrumbs'][] = ['label' => 'Nextofkins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nextofkin-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'full_Name',
            'nric',
            'contact',
            [
                'label' => 'Next-of-kin of',
                'format' => 'raw',
                'value' => (new Floor())->getResidentList($model->id),
            ],
            'email:email',
            'remark',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
