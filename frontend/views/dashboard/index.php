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
    <div class="row">
        <?php
        $count = 0;
        foreach ($floorList as $item) {
            $count++;
            echo "<div class='col-sm-6'>
                <a href='".Yii::$app->homeUrl."dashboard/floordetail?id=".$item['id']."'>
                <table class='tableDashboard'>
                <tr>
                <td>
                # " . $count . "<br>
                Room: <font color='#3b9bfc'>" . $item['label'] . "</font><br>
                Patient: <font color='#3b9bfc'>" . ((new CommonFunction())->getResidentCount($item['id'])) . "</font><br>
                Caregiver: <font color='#3b9bfc'>" . ((new CommonFunction())->getCaregiverCount($item['id'])) . "</font><br>
                </td>
                </tr>
                </table>
                <br>
            </div>";
        }
        ?>
    </div>
</div>


<style>
    a:link {
        text-decoration: none;
    }
</style>