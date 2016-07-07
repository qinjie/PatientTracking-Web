<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ResidentLocationHistory */

$this->title = 'Create Resident Location History';
$this->params['breadcrumbs'][] = ['label' => 'Resident Location Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resident-location-history-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
