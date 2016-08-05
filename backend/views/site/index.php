<?php

/* @var $this yii\web\View */
use common\models\CommonFunction;

$this->title = 'Patient Tracking System';

?>

<div class="site-index">
    <div class="jumbotron">
        <table align="center">
            <tr>
                <td>
                    <img src='main.ico' height="55px">
                </td>
                <td>
                    <h1>
                        Patient Tracking
                    </h1>
                </td>
            </tr>
        </table>
    </div>

    <div class="body-content">
        <!-- Main content -->
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-6 col-sm-6">
                <!-- small box -->
                <div class="small-box bg-teal-active">
                    <div class="inner">
                        <h4>Humans</h4>
                        <p>&nbsp;</p>
                    </div>
                    <div class="icon inner">
                        <i class="ion ion-person"></i>
                    </div>
                </div>
                <div>
                    <div>
                        <div class="info-box">
                            <a href="resident">
                                <span class="info-box-icon bg-teal-active"><i class="ion ion-person"></i></span>
                                <div class="info-box-content">
                                    <font color="black">
                                        <span class="info-box-number">Resident</span>
                                        <span class="info-box-text"><?= (new CommonFunction())->getResidentNumber(); ?></span>
                                    </font>

                                </div>
                            </a>
                        </div><!-- /.info-box -->
                    </div>
                    <div>
                        <div class="info-box">
                            <a href="nextofkin">
                                <span class="info-box-icon bg-teal-active"><i class="ion ion-person-add"></i></span>
                                <div class="info-box-content">
                                    <font color="black">
                                        <span class="info-box-number">Next of kin</span>
                                        <span class="info-box-text"><?= (new CommonFunction())->getNextofkinNumber(); ?></span>
                                    </font>

                                </div>
                            </a>
                        </div><!-- /.info-box -->
                    </div>
                    <div>
                        <div class="info-box">
                            <a href="resident-relative">
                                <span class="info-box-icon bg-teal-active"><i class="ion ion-person-stalker"></i></span>
                                <div class="info-box-content">
                                    <font color="black">
                                        <span class="info-box-number">Resident relative</span>
                                        <span class="info-box-text"><?= (new CommonFunction())->getResidentRelativeNumber(); ?></span>
                                    </font>

                                </div>
                            </a>
                        </div><!-- /.info-box -->
                    </div>
                    <div>
                        <div class="info-box">
                            <a href="user">
                                <span class="info-box-icon bg-teal-active"><i class="ion ion-person"></i></span>
                                <div class="info-box-content">
                                    <font color="black">
                                        <span class="info-box-number">User</span>
                                        <span class="info-box-text"><?= (new CommonFunction())->getUserNumber(); ?></span>
                                    </font>

                                </div>
                            </a>
                        </div><!-- /.info-box -->
                    </div>
                    <div>
                        <div class="info-box">
                            <a href="tag">
                                <span class="info-box-icon bg-teal-active"><i class="ion ion-pinpoint"></i></span>
                                <div class="info-box-content">
                                    <font color="black">
                                        <span class="info-box-number">Tag</span>
                                        <span class="info-box-text"><?= (new CommonFunction())->getTagNumber(); ?></span>
                                    </font>

                                </div>
                            </a>
                        </div><!-- /.info-box -->
                    </div>
                    <div>
                        <div class="info-box">
                            <a href="location">
                                <span class="info-box-icon bg-teal-active"><i class="ion ion-location"></i></span>
                                <div class="info-box-content">
                                    <font color="black">
                                        <span class="info-box-number">Current location</span>
                                        <span class="info-box-text"><?= (new CommonFunction())->getLocationNumber(); ?></span>
                                    </font>

                                </div>
                            </a>
                        </div><!-- /.info-box -->
                    </div>
                    <div>
                        <div class="info-box">
                            <a href="location-history">
                                <span class="info-box-icon bg-teal-active"><i class="ion ion-ios-book"></i></span>
                                <div class="info-box-content">
                                    <font color="black">
                                        <span class="info-box-number">Location history</span>
                                        <span class="info-box-text"><?= (new CommonFunction())->getLocationHistoryNumber(); ?></span>
                                    </font>

                                </div>
                            </a>
                        </div><!-- /.info-box -->
                    </div>
                </div>
            </div><!-- ./col -->
            <div class="col-lg-6 col-sm-6">
                <!-- small box -->
                <div class="small-box bg-aqua-active">
                    <div class="inner">
                        <h4>Floors</h4>
                        <p>&nbsp;</p>
                    </div>
                    <div class="icon inner">
                        <i class="ion ion-home"></i>
                    </div>
                </div>
                <div>
                    <div>
                        <div class="info-box">
                            <a href="floor">
                                <span class="info-box-icon bg-aqua-active"><i class="ion ion-home"></i></span>
                                <div class="info-box-content">
                                    <font color="black">
                                        <span class="info-box-number">Floor</span>
                                        <span class="info-box-text"><?= (new CommonFunction())->getFloorNumber(); ?></span>
                                    </font>

                                </div>
                            </a>
                        </div><!-- /.info-box -->
                    </div>
                    <div>
                        <div class="info-box">
                            <a href="floor-map">
                                <span class="info-box-icon bg-aqua-active"><i class="ion ion-map"></i></span>
                                <div class="info-box-content">
                                    <font color="black">
                                        <span class="info-box-number">Floor map</span>
                                        <span class="info-box-text"><?= (new CommonFunction())->getFloorMapNumber(); ?></span>
                                    </font>

                                </div>
                            </a>
                        </div><!-- /.info-box -->
                    </div>
                    <div>
                        <div class="info-box">
                            <a href="floor-manager">
                                <span class="info-box-icon bg-aqua-active"><i class="ion ion-home"></i></span>
                                <div class="info-box-content">
                                    <font color="black">
                                        <span class="info-box-number">Floor manager</span>
                                        <span class="info-box-text"><?= (new CommonFunction())->getFloorManagerNumber(); ?></span>
                                    </font>

                                </div>
                            </a>
                        </div><!-- /.info-box -->
                    </div>
                    <div>
                        <div class="info-box">
                            <a href="marker">
                                <span class="info-box-icon bg-aqua-active"><i class="ion ion-android-locate"></i></span>
                                <div class="info-box-content">
                                    <font color="black">
                                        <span class="info-box-number">Marker</span>
                                        <span class="info-box-text"><?= (new CommonFunction())->getMarkerNumber(); ?></span>
                                    </font>

                                </div>
                            </a>
                        </div><!-- /.info-box -->
                    </div>
                    <div>
                        <div class="info-box">
                            <a href="alert-area">
                                <span class="info-box-icon bg-aqua-active"><i class="ion ion-alert-circled"></i></span>
                                <div class="info-box-content">
                                    <font color="black">
                                        <span class="info-box-number">Alert area</span>
                                        <span class="info-box-text"><?= (new CommonFunction())->getAlertAreaNumber(); ?></span>
                                    </font>
                                </div>
                            </a>
                        </div><!-- /.info-box -->
                    </div>
                    <div>
                        <div class="info-box">
                            <a href="button">
                                <span class="info-box-icon bg-aqua-active"><i class="ion ion-power"></i></span>
                                <div class="info-box-content">
                                    <font color="black">
                                        <span class="info-box-number">Button</span>
                                        <span class="info-box-text"><?= (new CommonFunction())->getButtonNumber(); ?></span>
                                    </font>
                                </div>
                            </a>
                        </div><!-- /.info-box -->
                    </div>
                    <div>
                        <div class="info-box">
                            <a href="button-history">
                                <span class="info-box-icon bg-aqua-active"><i class="ion ion-ios-book-outline"></i></span>
                                <div class="info-box-content">
                                    <font color="black">
                                        <span class="info-box-number">Button History</span>
                                        <span class="info-box-text"><?= (new CommonFunction())->getButtonHistoryNumber(); ?></span>
                                    </font>
                                </div>
                            </a>
                        </div><!-- /.info-box -->
                    </div>
                </div>
            </div><!-- ./col -->
        </div><!-- /.row -->
        <!-- Main row -->
    </div>
</div>


