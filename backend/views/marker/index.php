<?php
use yii\helpers\Html;
use backend\models\CommonFunction;

$this->title = 'Markers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div align="center">
    <h1><?= Html::encode($this->title);?></h1>
</div>
<br>
<div class="patient-index">
</div>
<?php
$count = 0;
foreach ($floorList as $item){
    if ($count%2 == 0){
        echo "<div class=\"border row\">";
        echo "<div class=\"border col-sm-6\">";
    }
    else{
        echo "<div class=\"border col-sm-6\">";
    }
    $count++;
    echo "<table class='tableDashboard'>";
    echo "<tr>";
    echo "<td>";
    echo "No. ".$count."<br>";
    if (file_exists($filePath = (new CommonFunction())->getThumbnailPath($item['id']))){
        echo "Room: <a href='".Yii::$app->homeUrl."marker/floordetail?id=".$item['id']."'>".$item['label']."</a><br>";
        echo "</td>";
        echo "<td>";
        echo "<div align='right'><img src='".$filePath."' ></div>";
    }
    else{
        echo "Room: ".$item['label']."<br>";
        echo "You need to upload floor map first!<br>";
        echo "Go to <a href='".Yii::$app->homeUrl."floor-map'>Floor map</a>";
        echo "</td>";
        echo "<td>";
        echo "<div align='right'><img src='na.png' height='100' ></div>";
    }
    echo "</td>";
    echo "<td>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "<br>";
    if ($count%2 == 0) {
        echo "</div>";
        echo "</div>";
    } else {
        echo "</div>";
    }
}
if ($count%2 == 1){
    echo "</div>";
}
?>

<?php
//
//use yii\helpers\Html;
//use yii\grid\GridView;
//
///* @var $this yii\web\View */
///* @var $searchModel backend\models\MarkerSearch */
///* @var $dataProvider yii\data\ActiveDataProvider */
//
//$this->title = 'Markers';
//$this->params['breadcrumbs'][] = $this->title;
//?>
<!--<div class="marker-index">-->
<!---->
<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->
<!--    --><?php //// echo $this->render('_search', ['model' => $searchModel]); ?>
<!---->
<!--    <p>-->
<!--        --><?//= Html::a('Create Marker', ['create'], ['class' => 'btn btn-success']) ?>
<!--    </p>-->
<!--    --><?//= GridView::widget([
//        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
//        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//
//            'id',
//            'label',
//            'mac',
//            'floor_id',
//            'position',
//            // 'pixelx',
//            // 'pixely',
//            // 'coorx',
//            // 'coory',
//            // 'created_at',
//            // 'updated_at',
//
//            ['class' => 'yii\grid\ActionColumn'],
//        ],
//    ]); ?>
<!--</div>-->
