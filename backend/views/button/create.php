<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Button */

$this->title = 'Create Button';
$this->params['breadcrumbs'][] = ['label' => 'Buttons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="button-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
