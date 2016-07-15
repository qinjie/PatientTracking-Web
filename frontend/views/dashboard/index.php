<?php
use yii\helpers\Html;
use common\models\CommonFunction;

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<div align="center">
    <h1><?= Html::encode($this->title);?></h1>
</div>
<div align="right">
    <?= Html::a('Go to Alert', ['alertdetail'], ['class' => 'btn btn-danger']) ?>
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
    echo "<a href='".Yii::$app->homeUrl."dashboard/floordetail?id=".$item['id']."'>";
    echo "<table class='tableDashboard'>";
    echo "<tr>";
    echo "<td>";
    echo "No. ".$count."<br>";
    echo "Room: <font color='#3b9bfc'>".$item['label']."</font><br>";
    echo "Number of patient: <font color='#3b9bfc'>".((new CommonFunction())->getResidentCount($item['id']))."</font><br>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "</a>";
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