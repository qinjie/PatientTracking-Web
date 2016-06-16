<?php
use yii\helpers\Html;
use backend\models\CommonFunction;
use yii\grid\GridView;
/* @var $searchModel backend\models\ResidentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Alert list';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div align="center">
    <h1><?= Html::encode($this->title) ?></h1>
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
            'attribute' => 'residentName',
            'value'=>function ($data) {
                return Html::a(Html::encode($data->residentName),Yii::$app->homeUrl.'dashboard/residentdetail?id='.$data->resident_id);}
        ],
        'residentGender',
        'residentBirthday',
        [
            'label' => 'Last floor',
            'attribute' => 'floorName',
            'value' => 'floorName',
        ],
        'coorx',
        'coory',
        'speed',
    ],
]); ?>
