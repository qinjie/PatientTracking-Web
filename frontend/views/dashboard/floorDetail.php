<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\CommonFunction;
use yii\bootstrap\Modal;
/* @var $searchModel common\models\ResidentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Floor Details';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$imagePath = (new \common\models\CommonFunction())->getImgPath($id);

?>
<div align="center">
    <h1><?= Html::encode($floorName) ?></h1>
</div>
<br>
<?php
Modal::begin([
    'header' => '<h4>Resident detail</h4>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();

Pjax::begin(['id' => 'PjaxGrid']);
    $arrayCoor = (new CommonFunction())->getMappoints($id);
    echo "<input id='arrayCoor' type=text value='".json_encode($arrayCoor)."' hidden>";
    echo "<script>showPatient()</script>";
    echo "<script>showCoords()</script>";
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label'=>'Full Name',
                'format' => 'raw',
                'attribute' => 'residentName',
                'value'=>function ($data) {
                    return Html::a(Html::encode($data->residentName),Yii::$app->homeUrl.'resident/view?id='.$data->resident_id);}
            ],
            'residentGender',
            'residentBirthday',
            'coorx',
            'coory',
            'speed',
            'azimuth',
        ],
    ]);
Pjax::end();
if ((new CommonFunction())->checkImageExist($id)){
    echo "<h3 style=\"color: #00a7d0\">Floor map</h3>";
}
?>
<div class="marker-index">
    <div align="center" class="marker-view">
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

<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>

<script>

    $(function() {
        $("#image").click(function(e) {
            var pos_x = (event.offsetX);
            var pos_y = (event.offsetY);
            var array = JSON.parse(document.getElementById("arrayCoor").value);
            var rid = null;
            var distance = 100;
            for (i = 0; i < array.length; i++){
                var d = Math.pow(pos_x - array[i]['pixelx'], 2) + Math.pow(pos_y - array[i]['pixely'], 2) ;
                if (d <= 100 && d <= distance){
                    rid = array[i]['id'];
                    distance = d;
                }
            }
            if (rid != null){
                $.ajax({
                    type: "GET",
                    url: "<?= Yii::$app->homeUrl?>resident/viewmodal?id=" + rid,
                    data: "x="+pos_x+"&y="+pos_y,
                    success:function(data) {
                        $('#modal').modal('show')
                            .find('#modalContent')
                            .html(data);
                    }
                });
            }
        });
    });

    var img = new Image();
    img.src = "../../../backend/web/"+<?php echo json_encode($imagePath); ?>;
    img.onload = function() {
        draw(this);
    };

    function draw(img) {
        var canvas = document.getElementById('myCanvas');
        canvas.width = img.width;
        canvas.height = img.height;
        var ctx = canvas.getContext('2d');
        ctx.drawImage(img, 0, 0);
        img.style.display = 'none';
    };

    function showCoords(event) {
        var array = JSON.parse(document.getElementById("arrayCoor").value);
        var pos_x = (event.offsetX);
        var pos_y = (event.offsetY);
        var array = JSON.parse(document.getElementById("arrayCoor").value);
        var name = null;
        var distance = 100;
        for (i = 0; i < array.length; i++){
            var d = Math.pow(pos_x - array[i]['pixelx'], 2) + Math.pow(pos_y - array[i]['pixely'], 2) ;
            if (d <= 100 && d <= distance){
                name = array[i]['firstname'];
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
    function showPatient(){
        var array = JSON.parse(document.getElementById("arrayCoor").value);
        var img = new Image();
        img.src = "../../../backend/web/"+<?php echo json_encode($imagePath); ?>;
        img.onload = function() {
            var canvas = document.getElementById('myCanvas');
            canvas.width = img.width;
            canvas.height = img.height;
            var ctx = canvas.getContext('2d');
            ctx.drawImage(img, 0, 0);
            img.style.display = 'none';
            for(var i=0; i<array.length; i++){
                ctx.beginPath();
                ctx.arc(array[i]['pixelx'], array[i]['pixely'], 10, 0, 2 * Math.PI, false);
                ctx.fillStyle = '#F44336';
                ctx.fill();
            }
            for(var i=0; i<array.length; i++){
                ctx.font="18px Arial";
                ctx.fillStyle = "#0277BD";
                ctx.textAlign = "center";
                ctx.fillText(array[i]['firstname'], array[i]['pixelx'], array[i]['pixely'] - 15);
            }
        };
    }

    showPatient();

    setInterval(function () {
        $.pjax.reload({container:'#PjaxGrid'});
    }, 3000)


</script>
