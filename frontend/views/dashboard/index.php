<?php
use yii\helpers\Html;
use backend\models\CommonFunction;

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<div align="center">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
<br>
<div class="patient-index">
</div>
<?php
$floorList = (new CommonFunction())->getAllFloor();
$count = 0;
foreach ($floorList as $item){
    if ($count%2 == 0){
        $css = "tableEven";
    }
    else{
        $css = "tableOdd";
    }
    echo "<table class=\"".$css."\">";
    echo "<tr>";
    echo "<td>";
    $count++;
    echo "Number: ".$count."<br>";
    echo "Room: <a href='".Yii::$app->homeUrl."dashboard/floordetail?id=".$item['id']."'>".$item['label']."</a><br>";
    echo "Nunmber of patient: ".((new CommonFunction())->getResidentCount($item['id']))."<br>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "<br>";
}
?>
