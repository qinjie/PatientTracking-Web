<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js" type="text/javascript"></script>

<style>
    /* jQuery Growl
 * Copyright 2015 Kevin Sylvestre
 * 1.3.2
 */
    #growls {
        z-index: 50000;
        position: fixed; }
    #growls.default {
        top: 10px;
        right: 10px; }
    #growls.tl {
        top: 10px;
        left: 10px; }
    #growls.tr {
        top: 10px;
        right: 10px; }
    #growls.bl {
        bottom: 10px;
        left: 10px; }
    #growls.br {
        bottom: 10px;
        right: 10px; }
    #growls.tc {
        top: 10px;
        right: 10px;
        left: 10px; }
    #growls.bc {
        bottom: 10px;
        right: 10px;
        left: 10px; }
    #growls.tc .growl, #growls.bc .growl {
        margin-left: auto;
        margin-right: auto; }

    .growl {
        opacity: 0.8;
        filter: alpha(opacity=80);
        position: relative;
        border-radius: 4px;
        -webkit-transition: all 0.4s ease-in-out;
        -moz-transition: all 0.4s ease-in-out;
        transition: all 0.4s ease-in-out; }
    .growl.growl-incoming {
        opacity: 0;
        filter: alpha(opacity=0); }
    .growl.growl-outgoing {
        opacity: 0;
        filter: alpha(opacity=0); }
    .growl.growl-small {
        width: 200px;
        padding: 5px;
        margin: 5px; }
    .growl.growl-medium {
        width: 250px;
        padding: 10px;
        margin: 10px; }
    .growl.growl-large {
        width: 300px;
        padding: 15px;
        margin: 15px; }
    .growl.growl-default {
        color: #FFF;
        background: #7f8c8d; }
    .growl.growl-error {
        color: #FFF;
        background: #C0392B; }
    .growl.growl-notice {
        color: #FFF;
        background: #2ECC71; }
    .growl.growl-warning {
        color: #FFF;
        background: #F39C12; }
    .growl .growl-close {
        cursor: pointer;
        float: right;
        font-size: 14px;
        line-height: 18px;
        font-weight: normal;
        font-family: helvetica, verdana, sans-serif; }
    .growl .growl-title {
        font-size: 18px;
        line-height: 24px; }
    .growl .growl-message {
        font-size: 14px;
        line-height: 18px; }
</style>

<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\CommonFunction;
use yii\bootstrap\Modal;
use common\models\Notification;
/* @var $searchModel common\models\ResidentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModelUser common\models\ResidentSearch */
/* @var $dataProviderUser yii\data\ActiveDataProvider */
$this->context->layout  = 'main2';
$this->title = $floorName;
$imagePath = (new \common\models\CommonFunction())->getImgPath($id);
list($width, $height, $type, $attr) = getimagesize("../../backend/web/".$imagePath);
$maxID = Notification::find()->max('id');
?>



<div id="container">
    <?php
        Modal::begin([
            'header' => '<h4>Information detail</h4>',
            'id' => 'modal',
            'size' => 'modal-lg',
        ]);
        echo "<div id='modalContent'></div>";
        Modal::end();
    ?>
    <div id="mapContainer" style="width: 80.02594033722438%;">
        <div>
            <div>
                <div>
                    <a id="image" onmousemove="showCoords(event)" onmouseout="clearCoor()" class="tooltipCustom">
                        <canvas id="myCanvas">
                            Your browser does not support the HTML5 canvas tag.
                        </canvas>
                        <span>
                            <p id="coorxy"></p>
                        </span>
                    </a>
                </div>
            </div>
        </div>
<!--        <img style="position: absolute; right: 0px; top: 0px;" class="fullscreen-button" src="../../web/fullscreen_icon.png" width="35" height="35" onclick="goFullScreen();">-->
    </div>
    <div id="cPane" style="width: 19.974059662775616%;">
        <div id="tagContainer">
            <h3 align="center"><font color='#3b9bfc'>[<?= $floorName ?>]</font></h3>
            <?php
            Pjax::begin(['id' => 'Pjax']);

            echo "<h4 style=\"color: #00a7d0\">&nbsp;Alert</h4>";
            echo GridView::widget([
                'dataProvider' => $dataProviderAlert,
//                'filterModel' => $searchModelAlert,
                'rowOptions' => function ($data, $index, $widget, $grid){
                    if($data->user_id == null){
                        return ['class' => 'danger'];
                    }
                    else{
                        return ['class' => 'success'];
                    }
                },
                'summary'=>'',
                'columns' => [
                    [
                        'label'=>'Full Name',
                        'format' => 'raw',
                        'attribute' => 'residentName',
                        'value'=>function ($data) {
                            return Html::a(Html::encode($data->residentName),Yii::$app->homeUrl.'resident/view?id='.$data->resident_id);},
                        'enableSorting' => false,
                    ],
//                    [
//                        'label'=>'Gender',
//                        'attribute' => 'residentGender',
//                        'enableSorting' => false,
//                    ],
//                    [
//                        'label'=>'DoB',
//                        'attribute' => 'residentBirthday',
//                        'enableSorting' => false,
//                    ],
                    [
                        'label' => 'Floor',
                        'attribute' => 'floorName',
                        'value' => 'floorName',
                        'enableSorting' => false,
                    ],
                    [
                        'label' => 'Type',
                        'attribute'=>'alertType',
                        'value'=>'alertType',
                        'enableSorting' => false,
                    ],
                ],
            ]);
            echo "<br>";
            echo "<h4 style=\"color: #00a7d0\">&nbsp;Resident</h4>";
            $arrayCoor = (new CommonFunction())->getResidentPixel($id);
            $arrayCoorUser = (new CommonFunction())->getUserPixel($id);
            $arrayNotif = (new CommonFunction())->getNotification();
            echo "<input id='arrayNotif' type=text value='".json_encode($arrayNotif)."' hidden>";
            echo "<input id='arrayCoor' type=text value='".json_encode($arrayCoor)."' hidden>";
            echo "<input id='arrayCoorUser' type=text value='".json_encode($arrayCoorUser)."' hidden>";
            echo "<script>checkNotification()</script>";
            echo "<script>showPoint()</script>";
            echo "<script>showCoords()</script>";
            echo GridView::widget([
                'dataProvider' => $dataProvider,
//                'filterModel' => $searchModel,
                'summary'=>'',
                'columns' => [
                    [
                        'label'=>'Full Name',
                        'format' => 'raw',
                        'attribute' => 'residentName',
                        'value'=>function ($data) {
                            return Html::a(Html::encode($data->residentName),Yii::$app->homeUrl.'resident/view?id='.$data->resident_id);},
                        'enableSorting' => false,
                    ],
                    [
                        'attribute' => 'residentGender',
                        'enableSorting' => false,
                    ],
                    [
                        'attribute' => 'residentBirthday',
                        'enableSorting' => false,
                    ]
                ],
            ]);
            echo "<br>";
            echo "<h4 style=\"color: #00a7d0\">&nbsp;Caregiver</h4>";
            echo GridView::widget([
                'dataProvider' => $dataProviderUser,
//                'filterModel' => $searchModelUser,
                'summary'=>'',
                'showOnEmpty'=>true,
                'columns' => [
                    [
                        'format' => 'raw',
                        'attribute' => 'userName',
                        'value'=>function ($data) {
                            return Html::a(Html::encode($data->userName),Yii::$app->homeUrl.'dashboard/viewuser?id='.$data->user_id);},
                        'enableSorting' => false,
                    ],
                ],
            ]);
            Pjax::end();
            ?>
        </div>
    </div>
</div>


<script>
    function checkNotification() {
        (function() {
            "use strict";
            var $, Animation, Growl,
                bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

            $ = jQuery;

            Animation = (function() {
                function Animation() {}

                Animation.transitions = {
                    "webkitTransition": "webkitTransitionEnd",
                    "mozTransition": "mozTransitionEnd",
                    "oTransition": "oTransitionEnd",
                    "transition": "transitionend"
                };

                Animation.transition = function($el) {
                    var el, ref, result, type;
                    el = $el[0];
                    ref = this.transitions;
                    for (type in ref) {
                        result = ref[type];
                        if (el.style[type] != null) {
                            return result;
                        }
                    }
                };

                return Animation;

            })();

            Growl = (function() {
                Growl.settings = {
                    namespace: 'growl',
                    duration: 3200,
                    close: "&#215;",
                    location: "default",
                    style: "default",
                    size: "medium",
                    delayOnHover: true
                };

                Growl.growl = function(settings) {
                    if (settings == null) {
                        settings = {};
                    }
                    this.initialize();
                    return new Growl(settings);
                };

                Growl.initialize = function() {
                    return $("body:not(:has(#growls))").append('<div id="growls" />');
                };

                function Growl(settings) {
                    if (settings == null) {
                        settings = {};
                    }
                    this.container = bind(this.container, this);
                    this.content = bind(this.content, this);
                    this.html = bind(this.html, this);
                    this.$growl = bind(this.$growl, this);
                    this.$growls = bind(this.$growls, this);
                    this.animate = bind(this.animate, this);
                    this.remove = bind(this.remove, this);
                    this.dismiss = bind(this.dismiss, this);
                    this.present = bind(this.present, this);
                    this.waitAndDismiss = bind(this.waitAndDismiss, this);
                    this.cycle = bind(this.cycle, this);
                    this.close = bind(this.close, this);
                    this.click = bind(this.click, this);
                    this.mouseLeave = bind(this.mouseLeave, this);
                    this.mouseEnter = bind(this.mouseEnter, this);
                    this.unbind = bind(this.unbind, this);
                    this.bind = bind(this.bind, this);
                    this.render = bind(this.render, this);
                    this.settings = $.extend({}, Growl.settings, settings);
                    this.$growls().attr('class', this.settings.location);
                    this.render();
                }

                Growl.prototype.render = function() {
                    var $growl;
                    $growl = this.$growl();
                    this.$growls().append($growl);
                    if (this.settings.fixed) {
                        this.present();
                    } else {
                        this.cycle();
                    }
                };

                Growl.prototype.bind = function($growl) {
                    if ($growl == null) {
                        $growl = this.$growl();
                    }
                    $growl.on("click", this.click);
                    if (this.settings.delayOnHover) {
                        $growl.on("mouseenter", this.mouseEnter);
                        $growl.on("mouseleave", this.mouseLeave);
                    }
                    return $growl.on("contextmenu", this.close).find("." + this.settings.namespace + "-close").on("click", this.close);
                };

                Growl.prototype.unbind = function($growl) {
                    if ($growl == null) {
                        $growl = this.$growl();
                    }
                    $growl.off("click", this.click);
                    if (this.settings.delayOnHover) {
                        $growl.off("mouseenter", this.mouseEnter);
                        $growl.off("mouseleave", this.mouseLeave);
                    }
                    return $growl.off("contextmenu", this.close).find("." + this.settings.namespace + "-close").off("click", this.close);
                };

                Growl.prototype.mouseEnter = function(event) {
                    var $growl;
                    $growl = this.$growl();
                    return $growl.stop(true, true);
                };

                Growl.prototype.mouseLeave = function(event) {
                    return this.waitAndDismiss();
                };

                Growl.prototype.click = function(event) {
                    if (this.settings.url != null) {
                        event.preventDefault();
                        event.stopPropagation();
                        return window.open(this.settings.url);
                    }
                };

                Growl.prototype.close = function(event) {
                    var $growl;
                    event.preventDefault();
                    event.stopPropagation();
                    $growl = this.$growl();
                    return $growl.stop().queue(this.dismiss).queue(this.remove);
                };

                Growl.prototype.cycle = function() {
                    var $growl;
                    $growl = this.$growl();
                    return $growl.queue(this.present).queue(this.waitAndDismiss());
                };

                Growl.prototype.waitAndDismiss = function() {
                    var $growl;
                    $growl = this.$growl();
                    return $growl.delay(this.settings.duration).queue(this.dismiss).queue(this.remove);
                };

                Growl.prototype.present = function(callback) {
                    var $growl;
                    $growl = this.$growl();
                    this.bind($growl);
                    return this.animate($growl, this.settings.namespace + "-incoming", 'out', callback);
                };

                Growl.prototype.dismiss = function(callback) {
                    var $growl;
                    $growl = this.$growl();
                    this.unbind($growl);
                    return this.animate($growl, this.settings.namespace + "-outgoing", 'in', callback);
                };

                Growl.prototype.remove = function(callback) {
                    this.$growl().remove();
                    return typeof callback === "function" ? callback() : void 0;
                };

                Growl.prototype.animate = function($element, name, direction, callback) {
                    var transition;
                    if (direction == null) {
                        direction = 'in';
                    }
                    transition = Animation.transition($element);
                    $element[direction === 'in' ? 'removeClass' : 'addClass'](name);
                    $element.offset().position;
                    $element[direction === 'in' ? 'addClass' : 'removeClass'](name);
                    if (callback == null) {
                        return;
                    }
                    if (transition != null) {
                        $element.one(transition, callback);
                    } else {
                        callback();
                    }
                };

                Growl.prototype.$growls = function() {
                    return this.$_growls != null ? this.$_growls : this.$_growls = $('#growls');
                };

                Growl.prototype.$growl = function() {
                    return this.$_growl != null ? this.$_growl : this.$_growl = $(this.html());
                };

                Growl.prototype.html = function() {
                    return this.container(this.content());
                };

                Growl.prototype.content = function() {
                    return "<div class='" + this.settings.namespace + "-close'>" + this.settings.close + "</div>\n<div class='" + this.settings.namespace + "-title'>" + this.settings.title + "</div>\n<div class='" + this.settings.namespace + "-message'>" + this.settings.message + "</div>";
                };

                Growl.prototype.container = function(content) {
                    return "<div class='" + this.settings.namespace + " " + this.settings.namespace + "-" + this.settings.style + " " + this.settings.namespace + "-" + this.settings.size + "'>\n  " + content + "\n</div>";
                };

                return Growl;

            })();

            this.Growl = Growl;

            $.growl = function(options) {
                if (options == null) {
                    options = {};
                }
                return Growl.growl(options);
            };

            $.growl.error = function(options) {
                var settings;
                if (options == null) {
                    options = {};
                }
                settings = {
                    title: "New alert",
                    style: "error"
                };
                return $.growl($.extend(settings, options));
            };

            $.growl.notice = function(options) {
                var settings;
                if (options == null) {
                    options = {};
                }
                settings = {
                    title: "Notice!",
                    style: "notice"
                };
                return $.growl($.extend(settings, options));
            };

            $.growl.warning = function(options) {
                var settings;
                if (options == null) {
                    options = {};
                }
                settings = {
                    title: "Warning!",
                    style: "warning"
                };
                return $.growl($.extend(settings, options));
            };

        }).call(this);
        var array = JSON.parse(document.getElementById("arrayNotif").value);
        for (i = 0; i < array.length; i++){
            var alertType = "";
            if (array[i]['type'] !== undefined && array[i]['type'] === "1"){
                alertType = " went to alert area";
            }
            else{
                if (array[i]['type'] !== undefined && array[i]['type'] === "2"){
                    alertType = " pressed the button";
                }
                else{
                    alertType = " went out of tracking zone";
                }
            }
            $.growl.error({ message: array[i]['firstname'] + alertType });
        }
    }

    var imgWidth = <?php echo json_encode($width); ?>;
    var imgHeight = <?php echo json_encode($height); ?>;
    var wRatio = 0.8002594033722438;
    var enableModal = true;
    $(function() {
        $("#image").click(function(e) {
            if (enableModal){
                var pos_x = (event.offsetX);
                var pos_y = (event.offsetY);
                var array = JSON.parse(document.getElementById("arrayCoor").value);
                var arrayUser = JSON.parse(document.getElementById("arrayCoorUser").value);
                var id = null;
                var type = "resident";
                var distance = 100;
                for (i = 0; i < array.length; i++){
                    var d = Math.pow(pos_x - array[i]['pixelx']*window.innerWidth*wRatio/imgWidth, 2) + Math.pow(pos_y - array[i]['pixely']*window.innerHeight/imgHeight, 2) ;
                    if (d <= 100 && d <= distance){
                        id = array[i]['id'];
                        distance = d;
                    }
                }
                for (i = 0; i < arrayUser.length; i++){
                    var d = Math.pow(pos_x - arrayUser[i]['pixelx']*window.innerWidth*wRatio/imgWidth, 2) + Math.pow(pos_y - arrayUser[i]['pixely']*window.innerHeight/imgHeight, 2) ;
                    if (d <= 100 && d <= distance){
                        id = arrayUser[i]['id'];
                        distance = d;
                        type = "user";
                    }
                }
                if (id != null && type == "resident"){
                    $.ajax({
                        type: "GET",
                        url: "<?= Yii::$app->homeUrl?>resident/residentmodal?id=" + id,
                        success:function(data) {
                            $('#modal').modal('show')
                                .find('#modalContent')
                                .html(data);
                        }
                    });
                }
                if (id != null && type == "user"){
                    $.ajax({
                        type: "GET",
                        url: "<?= Yii::$app->homeUrl?>dashboard/usermodal?id=" + id,
                        success:function(data) {
                            $('#modal').modal('show')
                                .find('#modalContent')
                                .html(data);
                        }
                    });
                }
            }
        });
    });

    function showCoords(event) {
        if (enableModal){
            var array = JSON.parse(document.getElementById("arrayCoor").value);
            var arrayUser = JSON.parse(document.getElementById("arrayCoorUser").value);
            var pos_x = (event.offsetX);
            var pos_y = (event.offsetY);
            var name = null;
            var distance = 100;
            for (i = 0; i < array.length; i++){
                var d = Math.pow(pos_x - array[i]['pixelx']*window.innerWidth*wRatio/imgWidth, 2) + Math.pow(pos_y - array[i]['pixely']*window.innerHeight/imgHeight, 2) ;
                if (d <= 100 && d <= distance){
                    name = array[i]['firstname'];
                    distance = d;
                }
            }
            for (i = 0; i < arrayUser.length; i++){
                var d = Math.pow(pos_x - arrayUser[i]['pixelx']*window.innerWidth*wRatio/imgWidth, 2) + Math.pow(pos_y - arrayUser[i]['pixely']*window.innerHeight/imgHeight, 2) ;
                if (d <= 100 && d <= distance){
                    name = arrayUser[i]['username'];
                    distance = d;
                }
            }
            if (name != null){
                document.getElementById("coorxy").innerHTML = name;
            }
            else{
                document.getElementById("coorxy").innerHTML = "";
            }
        }
    }

    function clearCoor() {
        document.getElementById("coorxy").innerHTML = "";
    }
    var tooltips = document.querySelectorAll('.tooltipCustom span');
    window.onmousemove = function (e) {
        var x = (e.clientX + 10) + 'px',
            y = (e.clientY + 10) + 'px';
        for (var i = 0; i < tooltips.length; i++) {
            tooltips[i].style.top = y;
            tooltips[i].style.left = x;
        }
    };

    function showPoint(){
        var array = JSON.parse(document.getElementById("arrayCoor").value);
        var arrayUser = JSON.parse(document.getElementById("arrayCoorUser").value);
        var img = new Image();
        img.src = "../../../backend/web/"+<?php echo json_encode($imagePath); ?>;
        img.onload = function() {
            var canvas = document.getElementById('myCanvas');
            canvas.width = img.width;
            canvas.height = img.height;
            var ctx = canvas.getContext('2d');
            ctx.canvas.width = window.innerWidth*wRatio;
            ctx.canvas.height = window.innerHeight;
            ctx.drawImage(img, 0, 0, window.innerWidth*wRatio,window.innerHeight);
            img.style.display = 'none';
            for(var i=0; i<array.length; i++){
                ctx.beginPath();
                ctx.arc(array[i]['pixelx']*window.innerWidth*wRatio/imgWidth, array[i]['pixely']*window.innerHeight/imgHeight, 10, 0, 2 * Math.PI, false);
                if (array[i]['color'] == "RED"){
                    ctx.fillStyle = '#F44336';
                }else{
                    ctx.fillStyle = '#2196F3';
                }
                ctx.fill();
            }
            for(var i=0; i<arrayUser.length; i++){
                ctx.beginPath();
                ctx.arc(arrayUser[i]['pixelx']*window.innerWidth*wRatio/imgWidth, arrayUser[i]['pixely']*window.innerHeight/imgHeight, 10, 0, 2 * Math.PI, false);
                ctx.fillStyle = '#009688';
                ctx.fill();
            }
            for(var i=0; i<array.length; i++){
                ctx.font="28px Arial";
                ctx.fillStyle = "#0277BD";
                ctx.textAlign = "center";
                ctx.fillText(array[i]['firstname'], array[i]['pixelx']*window.innerWidth*wRatio/imgWidth, array[i]['pixely']*window.innerHeight/imgHeight - 15);
            }
            for(var i=0; i<arrayUser.length; i++){
                ctx.font="28px Arial";
                ctx.fillStyle = "#EF6C00";
                ctx.textAlign = "center";
                ctx.fillText(arrayUser[i]['username'], arrayUser[i]['pixelx']*window.innerWidth*wRatio/imgWidth, arrayUser[i]['pixely']*window.innerHeight/imgHeight - 15);
            }
            for(var i=0; i<array.length; i++){
                if (array[i]['outside'] == true){
                    ctx.font="15px Arial";
                    ctx.fillStyle = "#F44336";
                    ctx.textAlign = "center";
                    ctx.fillText("No signal", array[i]['pixelx']*window.innerWidth*wRatio/imgWidth, array[i]['pixely']*window.innerHeight/imgHeight + 25);
                }
            }
        };
    }

    showPoint();


    function goFullScreen(){
        wRatio = 1;
        var canvas = document.getElementById("myCanvas");
        if(canvas.requestFullScreen)
            canvas.requestFullScreen();
        else if(canvas.webkitRequestFullScreen)
            canvas.webkitRequestFullScreen();
        else if(canvas.mozRequestFullScreen)
            canvas.mozRequestFullScreen();
    }

    $(document).on('webkitfullscreenchange mozfullscreenchange fullscreenchange MSFullscreenChange', function () {
        if (!window.screenTop && !window.screenY) {
            wRatio = 0.8002594033722438;
            enableModal = true;
        }
        else{
            enableModal = false;
        }
    });
</script>

<?php
$script = <<< JS
 $(document).ready(function() {
    setInterval(function(){
    $.ajax({
        success: function(){
            $.pjax.reload({container:"#Pjax", async:false});
        }
    })
    }, 2000);
 });

JS;
$this->registerJs($script);
?>