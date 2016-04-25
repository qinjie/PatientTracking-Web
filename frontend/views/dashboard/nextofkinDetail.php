<?php
use yii\helpers\Html;
use backend\models\CommonFunction;
use yii\widgets\DetailView;

$this->title = 'Next-of-kin Details';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (new CommonFunction())->getFloorName($fid), 'url' => ['floordetail?id='.$fid]];
$this->params['breadcrumbs'][] = ['label' => (new CommonFunction())->getResidentName($rid), 'url' => ['residentdetail?id='.$rid.'&fid='.$fid]];
$this->params['breadcrumbs'][] = $this->title;
$model = (new CommonFunction())->getNextofkinModel($id);
?>

    <div align="center">
        <h1><?= Html::encode((new CommonFunction())->getNextofkinName($id)) ?></h1>
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