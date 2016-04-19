<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Nextofkin */

$this->title = 'Create Nextofkin';
$this->params['breadcrumbs'][] = ['label' => 'Nextofkins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nextofkin-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
