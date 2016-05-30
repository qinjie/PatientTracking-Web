<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\CommonFunction;

/* @var $this yii\web\View */
/* @var $model backend\models\FloorMap */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Floor Maps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="floor-map-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Create', ['create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'floor_id',
                'value' => $model->floorName,
            ],
            'file_type',
            'file_name',
            'file_ext',
            [
                'label' => 'File Path',
                'format' => 'raw',
                'value' => '<a href="'.Yii::$app->homeUrl.$model->file_path.'">'.$model->file_path.'</a>',
            ],
            [
                'label' => 'Thumbnail Path',
                'format' => 'raw',
                'value' => '<a href="'.Yii::$app->homeUrl.$model->thumbnail_path.'">'.$model->thumbnail_path.'</a>',
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>
    <div align="center">
        <table class="tableFloorMap">
            <tr>
                <td>
                    Thumbnail
                </td>
                <td>
                    Image
                </td>
            </tr>
            <tr>
                <td>
                    <img src="../../web/<?php echo $model->thumbnail_path; ?>">
                </td>
                <td>
                    <img src="../../web/<?php echo $model->file_path; ?>">
                </td>
            </tr>
        </table>
    </div>
</div>
