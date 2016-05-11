<?php
use yii\helpers\Html;
use backend\models\CommonFunction;

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<div align="center">
    <h1><?= Html::encode($this->title);
        
        ?></h1>
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
    echo "Room: <a href='".Yii::$app->homeUrl."dashboard/floordetail?id=".$item['id']."'>".$item['label']."</a><br>";
    echo "Nunmber of patient: ".((new CommonFunction())->getResidentCount($item['id']))."<br>";
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
