<?php
use yii\helpers\Html;
use backend\models\Floor;
use yii\grid\GridView;
/* @var $searchModel backend\models\FloorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Ward Details';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div align="center">
    <h1><?= Html::encode((new Floor())->getFloorName($id)) ?></h1>
</div>
<br>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'label'=>'Full Name',
            'format' => 'raw',
            'attribute' => 'fullName',
            'value'=>function ($data) use ($id) {
                return Html::a(Html::encode($data->fullName),Yii::$app->homeUrl.'dashboard/residentdetail?id='.$data->id.'&fid='.$id);}
        ],
        'gender',
        'birthday',
        'coorx',
        'coory',
        'speed',
    ],
]); ?>
