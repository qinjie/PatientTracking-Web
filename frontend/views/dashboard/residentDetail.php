<?php
use yii\helpers\Html;
use backend\models\Floor;
use yii\widgets\DetailView;

$this->title = 'Patient Details';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (new Floor())->getFloorName($fid), 'url' => ['floordetail?id='.$fid]];
$this->params['breadcrumbs'][] = $this->title;
$model = (new Floor())->getResidentModelByID($id);
?>

    <div align="center">
        <h1><?= Html::encode((new Floor())->getResidentName($id)) ?></h1>
    </div>
    <br>
    <br>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        [
            'label' => 'Name',
            'value' => (new Floor())->getResidentName($id),
        ],
        'nric',
        'gender',
        'birthday',
        [
            'label' => 'Next-of-kin',
            'format' => 'raw',
            'value' => (new Floor())->getNextofkinNameList($id, $fid),
        ],
        'contact',
        'remark',
        'lastmodified',
        'coorx',
        'coory',
        'speed',
    ],
]) ?>