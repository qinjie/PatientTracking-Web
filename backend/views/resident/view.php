<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Resident */

$this->title = $model->fullName;
$this->params['breadcrumbs'][] = ['label' => 'Residents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resident-view">

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
            'firstname',
            'lastname',
            'nric',
            'gender',
            'birthday',
            'contact',
            'remark',
            'file_path',
            'thumbnail_path',
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
