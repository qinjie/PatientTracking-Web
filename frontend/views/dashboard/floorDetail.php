<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\CommonFunction;
use yii\bootstrap\Modal;
/* @var $searchModel common\models\ResidentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModelUser common\models\ResidentSearch */
/* @var $dataProviderUser yii\data\ActiveDataProvider */
$this->context->layout  = 'main2';
$this->title = $floorName;
$imagePath = (new \common\models\CommonFunction())->getImgPath($id);
list($width, $height, $type, $attr) = getimagesize("../../backend/web/".$imagePath);
?>



<div id="container">
    <div id="mapContainer" style="width: 80.02594033722438%;">
        <div>
            <div>
                <div align="center">
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
        <img style="position: absolute; right: 0px; top: 0px;" class="fullscreen-button" src="../../web/fullscreen_icon.png" width="35" height="35" onclick="goFullScreen();">
    </div>
    <div id="cPane" style="width: 19.974059662775616%;">
        <div id="tagContainer">
            <h3 align="center"><?= $floorName ?></h3>
            <?php
            Modal::begin([
                'header' => '<h4>Detail</h4>',
                'id' => 'modal',
                'size' => 'modal-lg',
            ]);
            echo "<div id='modalContent'></div>";
            Modal::end();

            Pjax::begin(['id' => 'PjaxGrid']);

            echo "<h4 style=\"color: #00a7d0\" align='center'>Alert</h4>";
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
            echo "<h4 style=\"color: #00a7d0\" align='center'>Resident</h4>";
            $arrayCoor = (new CommonFunction())->getResidentPixel($id);
            $arrayCoorUser = (new CommonFunction())->getUserPixel($id);
            echo "<input id='arrayCoor' type=text value='".json_encode($arrayCoor)."' hidden>";
            echo "<input id='arrayCoorUser' type=text value='".json_encode($arrayCoorUser)."' hidden>";
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
            echo "<h4 style=\"color: #00a7d0\" align='center'>Caregiver</h4>";
            echo GridView::widget([
                'dataProvider' => $dataProviderUser,
//                'filterModel' => $searchModelUser,
                'summary'=>'',
                'columns' => [
                    [
                        'label'=>'Username',
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

<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>

<script>
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
                        url: "<?= Yii::$app->homeUrl?>resident/viewmodal?id=" + id,
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
                ctx.font="18px Arial";
                ctx.fillStyle = "#0277BD";
                ctx.textAlign = "center";
                ctx.fillText(array[i]['firstname'], array[i]['pixelx']*window.innerWidth*wRatio/imgWidth, array[i]['pixely']*window.innerHeight/imgHeight - 15);
            }
            for(var i=0; i<arrayUser.length; i++){
                ctx.font="18px Arial";
                ctx.fillStyle = "#EF6C00";
                ctx.textAlign = "center";
                ctx.fillText(arrayUser[i]['username'], arrayUser[i]['pixelx']*window.innerWidth*wRatio/imgWidth, arrayUser[i]['pixely']*window.innerHeight/imgHeight - 15);
            }
        };
    }

    showPoint();

    setInterval(function () {
        $.pjax.reload({container:'#PjaxGrid'});
    }, 2000)

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
