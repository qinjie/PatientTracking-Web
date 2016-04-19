<?php
use yii\helpers\Html;
use backend\models\Floor;
use yii\widgets\DetailView;

$this->title = 'Patient Details';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (new Floor())->getFloorName($fid), 'url' => ['floordetail?id='.$fid]];
$this->params['breadcrumbs'][] = ['label' => (new Floor())->getResidentName($rid), 'url' => ['residentdetail?id='.$rid.'&fid='.$fid]];
$this->params['breadcrumbs'][] = $this->title;
$model = (new Floor())->getNextofkinModelByID($id);
?>

    <div align="center">
        <h1><?= Html::encode((new Floor())->getNextofkinName($id)) ?></h1>
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