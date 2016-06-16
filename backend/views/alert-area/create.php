<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AlertArea */

$this->title = 'Create Alert Area';
$this->params['breadcrumbs'][] = ['label' => 'Alert Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alert-area-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
