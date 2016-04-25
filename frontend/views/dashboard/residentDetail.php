<?php
use yii\helpers\Html;
use backend\models\CommonFunction;
use yii\widgets\DetailView;

$this->title = 'Resident Details';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (new CommonFunction())->getFloorName($fid), 'url' => ['floordetail?id='.$fid]];
$this->params['breadcrumbs'][] = $this->title;
$model = (new CommonFunction())->getResidentModel($id);
?>

    <div align="center">
        <h1><?= Html::encode($model->fullName) ?></h1>
    </div>
    <br>
    <br>

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
            'value' => (new CommonFunction())->getNextofkinList($id, $fid),
        ],
        'contact',
        'remark',
        'lastmodified',
        'coorx',
        'coory',
        'speed',
    ],
]) ?>