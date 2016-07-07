<?php
use yii\helpers\Html;
use common\models\CommonFunction;

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

    if (file_exists($filePath = (new CommonFunction())->getThumbnailPath($item['id']))){
        echo "<a href='".Yii::$app->homeUrl."marker/floordetail?id=".$item['id']."'>";
        echo "<table class='tableDashboard'>";
        echo "<tr>";
        echo "<td>";
        echo "No. ".$count."<br>";
        echo "Room: <font color='#3b9bfc'>".$item['label']."</font><br>";
        echo "</td>";
        echo "<td>";
        echo "<div align='right'><img src='".$filePath."' ></div>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        echo "</a>";
    }
    else{
        echo "<table class='tableDashboard'>";
        echo "<tr>";
        echo "<td>";
        echo "No. ".$count."<br>";
        echo "Room: ".$item['label']."<br>";
        echo "You need to upload floor map first!<br>";
        echo "Go to <a href='".Yii::$app->homeUrl."floor-map'>Floor map</a>";
        echo "</td>";
        echo "<td>";
        echo "<div align='right'><img src='na.png' height='100' ></div>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
    }
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

<style>
    a:link {
        text-decoration: none;
    }
</style>