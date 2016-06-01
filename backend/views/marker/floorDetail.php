<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use backend\models\CommonFunction;
/* @var $searchModel backend\models\ResidentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Floor\'s Maker';
$this->params['breadcrumbs'][] = ['label' => 'Maker', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$imagePath = (new CommonFunction())->getImgPath($floorId);
?>

<div class="marker-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <table width="100%">
        <tr>
            <td align="left">
                <?= Html::button('Create Marker', ['value' => Url::toRoute(['create']), 'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
            </td>
            <td align="right">
                <input onclick="reload()" value="Show edges" type="button" id="reloadButton">
            </td>
        </tr>
    </table>

<!--    Modal-->
    <?php
    Modal::begin([
        'header' => '<h4>Marker</h4>',
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
    ?>

<!--    Map-->

    <div align="center" class="marker-view">
        <a id="test" onmousemove="showCoords(event)" onmouseout="clearCoor()" class="tooltipCustom">
            <canvas id="myCanvas" width="500" height="500">
                    Your browser does not support the HTML5 canvas tag.
            </canvas>
            <span>
                <p id="coorxy"></p>
            </span>
        </a>

    </div>
<!--    List-->
    <br>
    <h2>Marker list</h2>
    <?php Pjax::begin(['id' => 'PjaxGrid']);
    echo "<input id='nextPos' type=number value=".$nextPosition." hidden>";
    echo "<input id='markerList' type=text value='".json_encode((new CommonFunction())->getCoordinate($floorId))."' hidden>";
    echo "<script>refresh()</script>";
    echo "<script>$(\".activity-update-link\").click(function() {
        $.get(
            'update',
            {
                id: $(this).closest('tr').data('key')
            },
            function (data) {
                $('#modal').modal('show')
                    .find('#modalContent')
                    .html(data);
            }
        );
    });

    $(\".activity-view-link\").click(function() {
        $.get(
            'view',
            {
                id: $(this).closest('tr').data('key')
            },
            function (data) {
                $('#modal').modal('show')
                    .find('#modalContent')
                    .html(data);
            }
        );
    });</script>";

    ?>
    <?=GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'position',
            'id',
            'label',
            'mac',
            'floor_id',
             'pixelx',
             'pixely',
             'coorx',
             'coory',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::to(['companies/update']), [
                            'class' => 'activity-update-link',
                            'title' => Yii::t('yii', 'Update'),
                            'data-toggle' => 'modal',
                            'data-target' => '#modal',
                            'data-id' => $key,
                            'data-pjax' => '0',

                        ]);
                    },
                    'view' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>','view', [
                            'class' => 'activity-view-link',
                            'title' => Yii::t('yii', 'View'),
                            'data-toggle' => 'modal',
                            'data-target' => '#modal',
                            'data-id' => $key,
                            'data-pjax' => '0',

                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end() ?>
</div>


<!--Script-->
<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>

<script>
    $(".activity-update-link").click(function() {
        $.get(
            'update',
            {
                id: $(this).closest('tr').data('key')
            },
            function (data) {
                $('#modal').modal('show')
                    .find('#modalContent')
                    .html(data);
            }
        );
    });

    $(".activity-view-link").click(function() {
        $.get(
            'view',
            {
                id: $(this).closest('tr').data('key')
            },
            function (data) {
                $('#modal').modal('show')
                    .find('#modalContent')
                    .html(data);
            }
        );
    });

    $(function() {
        $("#test").click(function(e) {
            var offset = $(this).offset();
            var pos_x = (event.offsetX);
            var pos_y = (event.offsetY);
            var f = <?php echo json_encode($floorId); ?>;
            var p = document.getElementById("nextPos").value;
            $.ajax({
                type: "GET",
                url: "create",
                data: "x="+pos_x+"&y="+pos_y+"&p="+p+"&f="+f,
                success:function(data) {
                    $('#modal').modal('show')
                        .find('#modalContent')
                        .html(data);
                }
            });
        });
    });

    $(function () {
        $('#modalButton').click(function () {
            $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
        });
    });

    var img = new Image();
    img.src = "../../web/"+<?php echo json_encode($imagePath); ?>;
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

//        ctx.fillStyle = "red";
//        ctx.fillRect(10-5/2, 10-5/2, 5, 5);
//
//        ctx.strokeStyle = '#000000';
//        ctx.lineWidth = 5;
//        ctx.beginPath();
//        ctx.moveTo(107, 146);
//        ctx.lineTo(336, 326);
//        ctx.stroke();
//        ctx.closePath();
    };
    function reload() {
        var btn = document.getElementById('reloadButton');
            if (btn.value == "Show edges") {
                var arr = JSON.parse(document.getElementById("markerList").value);
                var x = [];
                var y = [];
                var count = 0;
                for (var i=0; i<arr.length; i++){
                    x[i] = parseInt(arr[i].pixelx);
                    y[i] = parseInt(arr[i].pixely);
                    count++;
                }
                var img = new Image();
                img.src = "../../web/"+<?php echo json_encode($imagePath); ?>;
                img.onload = function() {
                    var canvas = document.getElementById('myCanvas');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    var ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);
                    //color for dot
                    img.style.display = 'none';
                    ctx.fillStyle = "#0000FF";
                    //color for line
                    ctx.strokeStyle = '#ff0000';
                    ctx.lineWidth = 3;
                    for(var i=0; i<count - 1; i++){
                                ctx.beginPath();
                                ctx.moveTo(x[i], y[i]);
                                ctx.lineTo(x[i+1], y[i+1]);
                                ctx.stroke();
                                ctx.closePath();
                    }
                    if (count>0){
                        ctx.beginPath();
                        ctx.moveTo(x[count-1], y[count-1]);
                        ctx.lineTo(x[0], y[0]);
                        ctx.stroke();
                        ctx.closePath();
                    }
                    for(var i=0; i<count; i++){
                        ctx.fillRect(x[i]-5/2, y[i]-5/2, 5, 5);
                    }
                };
                btn.value = "Show original";
            }
            else {
                var img = new Image();
                img.src = "../../web/"+<?php echo json_encode($imagePath); ?>;
                img.onload = function() {
                    var canvas = document.getElementById('myCanvas');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    var ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);
                    img.style.display = 'none';
                };
                btn.value = "Show edges";
        }
    }

    function refresh() {
        var btn = document.getElementById('reloadButton');
        if (btn.value != "Show edges") {
            var arr = JSON.parse(document.getElementById("markerList").value);
            var x = [];
            var y = [];
            var count = 0;
            for (var i=0; i<arr.length; i++){
                x[i] = parseInt(arr[i].pixelx);
                y[i] = parseInt(arr[i].pixely);
                count++;
            }
            var img = new Image();
            img.src = "../../web/"+<?php echo json_encode($imagePath); ?>;
            img.onload = function() {
                var canvas = document.getElementById('myCanvas');
                canvas.width = img.width;
                canvas.height = img.height;
                var ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0);
                //color for dot
                img.style.display = 'none';
                ctx.fillStyle = "#0000FF";
                //color for line
                ctx.strokeStyle = '#ff0000';
                ctx.lineWidth = 3;
                for(var i=0; i<count - 1; i++){
                    ctx.beginPath();
                    ctx.moveTo(x[i], y[i]);
                    ctx.lineTo(x[i+1], y[i+1]);
                    ctx.stroke();
                    ctx.closePath();
                }
                if (count>0){
                    ctx.beginPath();
                    ctx.moveTo(x[count-1], y[count-1]);
                    ctx.lineTo(x[0], y[0]);
                    ctx.stroke();
                    ctx.closePath();
                }
                for(var i=0; i<count; i++){
                    ctx.fillRect(x[i]-5/2, y[i]-5/2, 5, 5);
                }
            };
        }
        else {
            var img = new Image();
            img.src = "../../web/"+<?php echo json_encode($imagePath); ?>;
            img.onload = function() {
                var canvas = document.getElementById('myCanvas');
                canvas.width = img.width;
                canvas.height = img.height;
                var ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0);
                img.style.display = 'none';
            };
        }
    }

    function showCoords(event) {
        var x = event.offsetX;
        var y = event.offsetY;
        var coor = "X: " + x + ", Y: " + y;
        document.getElementById("coorxy").innerHTML = coor;
    }

    function clearCoor() {
        document.getElementById("coorxy").innerHTML = "";
    }

    //
    var tooltips = document.querySelectorAll('.tooltipCustom span');

    window.onmousemove = function (e) {
        var x = (e.clientX + 20) + 'px',
            y = (e.clientY + 20) + 'px';
        for (var i = 0; i < tooltips.length; i++) {
            tooltips[i].style.top = y;
            tooltips[i].style.left = x;
        }
    };

    init_click_handlers(); //first run
    $("#modal").on("pjax:success", function() {
        init_click_handlers(); //reactivate links in grid after pjax update
    });

</script>

<!--<script>-->
<!--    $(document).ready(function(){-->
<!--        $(document).click(function (ev) {-->
<!--            mouseX = ev.pageX;-->
<!--            mouseY = ev.pageY-->
<!--            console.log(mouseX + ' ' + mouseY);-->
<!--            var color = '#000000';-->
<!--            var size = '3px';-->
<!--            $("body").append(-->
<!--                $('<div></div>')-->
<!--                    .css('position', 'absolute')-->
<!--                    .css('top', mouseY + 'px')-->
<!--                    .css('left', mouseX + 'px')-->
<!--                    .css('width', size)-->
<!--                    .css('height', size)-->
<!--                    .css('background-color', color)-->
<!--            );-->
<!--        });-->
<!--    });-->
<!--</script>-->
