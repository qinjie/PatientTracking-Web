<?php
use yii\helpers\Html;
use backend\models\CommonFunction;
use yii\widgets\DetailView;

$this->title = 'Resident Details';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['index']];
if ($floorName != null) {
    $this->params['breadcrumbs'][] = ['label' => $floorName, 'url' => ['floordetail?id='.$fid]];
}
else{
    $this->params['breadcrumbs'][] = ['label' => 'Alert list', 'url' => ['alertdetail']];
}
$this->params['breadcrumbs'][] = $this->title;
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