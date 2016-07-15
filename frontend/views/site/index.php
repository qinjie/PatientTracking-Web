<?php
/* @var $this yii\web\View */

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
                    Patient Tracking
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
<p align="left">
    <h2><font color="#00BCD4">Quick Report</font></h2>
</p>
<br>
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
                    <p>Alert patient</p>
                </div>
                <div class="icon inner">
                    <i class="ion ion-alert-circled"></i>
                </div>
            </div>
        </div>
    </a>
</div><!-- /.row -->
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