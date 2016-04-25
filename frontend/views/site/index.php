<?php
/* @var $this yii\web\View */

$this->title = Yii::$app->name;
?>

<!-- Content Header (Page header) -->
<h3>
    Quick report
</h3>
<br>
<!-- Main content -->
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?php echo $residentNumber; ?></h3>
                <p>Resident Number</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
            <a href="resident" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?php echo $nextofkinNumber; ?></h3>
                <p>Next-of-kin number</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
            <a href="nextofkin" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?php echo $floorNumber ?></h3>
                <p>Floor number</p>
            </div>
            <div class="icon">
                <i class="ion ion-home"></i>
            </div>
            <a href="dashboard" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>2</h3>
                <p>Out of range patient</p>
            </div>
            <div class="icon">
                <i class="ion ion-alert-circled
                            "></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
</div><!-- /.row -->
<!-- Main row -->
