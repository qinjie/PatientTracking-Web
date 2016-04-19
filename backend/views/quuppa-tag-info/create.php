<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\QuuppaTagInfo */

$this->title = 'Create Quuppa Tag Info';
$this->params['breadcrumbs'][] = ['label' => 'Quuppa Tag Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quuppa-tag-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
