<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\QuuppaTagPosition */

$this->title = 'Create Quuppa Tag Position';
$this->params['breadcrumbs'][] = ['label' => 'Quuppa Tag Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quuppa-tag-position-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
