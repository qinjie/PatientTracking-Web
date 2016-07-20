<?php
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $searchModel backend\models\ResidentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Floor Details';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div align="center">
    <h1><?= Html::encode($floorName) ?></h1>
</div>
<br>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'label'=>'Full Name',
            'format' => 'raw',
            'attribute' => 'residentName',
            'value'=>function ($data) {
                return Html::a(Html::encode($data->residentName),Yii::$app->homeUrl.'dashboard/residentdetail?id='.$data->resident_id);}
        ],
        'residentGender',
        'residentBirthday',
        'coorx',
        'coory',
        'speed',
        'azimuth',
    ],
]); ?>
