<?php
use yii\helpers\Html;
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
<div align="left">
    <?= Html::a('Back to Dashboard', ['/dashboard'], ['class' => 'btn btn-success']) ?>
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
                return Html::a(Html::encode($data->residentName),Yii::$app->homeUrl.'resident/view?id='.$data->resident_id);}
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
        'azimuth',
        [
            'label' => 'Alert type',
            'attribute'=>'outside',
            'value'=>'outsideAlert',
            'filter'=>array(0=>"Time out", 1=>"Outside"),
        ],
    ],
]); ?>
