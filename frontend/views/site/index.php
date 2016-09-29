<?php
/* @var $this yii\web\View */

use miloschuman\highcharts\Highcharts;
use common\models\Resident;
use common\models\Nextofkin;

$this->title = Yii::$app->name;
?>
<div class="jumbotron">
    <table align="center">
        <tr>
            <td>
                <img src='main.ico' height="55px">
            </td>
            <td>
                &nbsp;
            </td>
            <td>
                <h1>
                    Resident Tracking
                </h1>
            </td>
        </tr>
    </table>
</div>
<!-- Content Header (Page header) -->
<!--<h3>-->
<!--    Quick report-->
<!--</h3>-->
<!-- Main content -->
<!-- Small boxes (Stat box) -->
<div class="row">
    <a href="resident">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?php echo $residentNumber; ?></h3>
                    <p>Resident</p>
                </div>
                <div class="icon inner">
                    <i class="ion ion-person"></i>
                </div>
            </div>
        </div>
    </a>
    <a href="nextofkin">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3><?php echo $nextofkinNumber; ?></h3>
                    <p>Next-of-kin</p>
                </div>
                <div class="icon inner">
                    <i class="ion ion-person-stalker"></i>
                </div>
            </div>
        </div>
    </a>
    <a href="dashboard">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?php echo $floorNumber; ?></h3>
                    <p>Floor</p>
                </div>
                <div class="icon inner">
                    <i class="ion ion-home"></i>
                </div>
            </div>
        </div>
    </a>
    <a href="dashboard/alertdetail">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>
                        <?php \yii\widgets\Pjax::begin(['id' => 'count']);
                        echo (new \common\models\CommonFunction())->getAlertCount();
                        \yii\widgets\Pjax::end();
                        ?>
                    </h3>
                    <p>Alert</p>
                </div>
                <div class="icon inner">
                    <i class="ion ion-alert-circled"></i>
                </div>
            </div>
        </div>
    </a>
</div><!-- /.row -->
<br>
<?php
$thisMonth = date('Y-m-01 00:00:00', time());
$lastMonth = date('Y-m-01 00:00:00', strtotime('-1 month'));
$last2Month = date('Y-m-01 00:00:00', strtotime('-2 month'));
$countResidentThisMonth = Resident::find()->andWhere("created_at >= '{$thisMonth}'")->count();
$countResidentLastMonth = Resident::find()->andWhere("created_at <= '{$thisMonth}' and created_at >= '{$lastMonth}'")->count();
$countResidentLast2Month = Resident::find()->andWhere("created_at <= '{$lastMonth}' and created_at >= '{$last2Month}'")->count();
$countNextofkinThisMonth = Nextofkin::find()->andWhere("created_at >= '{$thisMonth}'")->count();
$countNextofkinLastMonth = Nextofkin::find()->andWhere("created_at <= '{$thisMonth}' and created_at >= '{$lastMonth}'")->count();
$countNextofkinLast2Month = Nextofkin::find()->andWhere("created_at <= '{$lastMonth}' and created_at >= '{$last2Month}'")->count();
echo Highcharts::widget([
    'options' => [
        'title' => ['text' => 'Residents and Next-of-kin changes'],
        //'subtitle' => ['text' => 'Count of posts and registered users'],
        'chart' => ['type' => 'column'],
        'xAxis' => [
            'categories' => [date('F', strtotime('-2 month')), date('F', strtotime('-1 month')), date('F', time())],
            'crosshair'=> true
        ],
        'yAxis' => [
            'title' => ['text' => 'Counts'],
            'min' => 0
        ],
        'tooltip'=>[
            'headerFormat'=>'<span style="font-size:10px">{point.key}</span><table>',
            'pointFormat'=>'<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y}</b></td></tr>',
            'footerFormat'=>'</table>',
            'shared'=>true,
            'useHTML'=>true,
        ],
        'plotOptions'=>[
            'column'=>[
                'pointPadding'=>0.2,
                'borderWidth'=>0,
            ],
        ],
        'series' => [
            ['name' => 'Resident', 'data' => [(int) $countResidentLast2Month, (int) $countResidentLastMonth, (int) $countResidentThisMonth]],
            ['name' => 'NextOfKin', 'data' => [(int) $countNextofkinLast2Month, (int) $countNextofkinLastMonth, (int) $countNextofkinThisMonth]],
        ]
    ]
]);
?>
<!-- Main row -->

<?php
$script = <<< JS
 $(document).ready(function() {
    setInterval(function(){
    $.ajax({
        success: function(){
            $.pjax.reload({container:"#count", async:false});
        }
    })
    }, 1000);
 });

JS;
$this->registerJs($script);
?>