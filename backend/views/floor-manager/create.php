<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\FloorManager */

$this->title = 'Create Floor Manager';
$this->params['breadcrumbs'][] = ['label' => 'Floor Managers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="floor-manager-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
