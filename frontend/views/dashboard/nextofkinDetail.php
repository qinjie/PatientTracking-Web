<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Next-of-kin Details';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $floorName, 'url' => ['floordetail?id='.$fid]];
$this->params['breadcrumbs'][] = ['label' => $residentName, 'url' => ['residentdetail?id='.$rid.'&fid='.$fid]];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div align="center">
        <h1><?= Html::encode($nextofkinName) ?></h1>
    </div>
    <br>
    <br>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'nric',
        'first_name',
        'last_name',
        'contact',
        'email',
        'remark',
        'created_at',
        'updated_at',
    ],
]) ?>