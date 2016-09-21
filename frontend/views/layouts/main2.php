<link rel="shortcut icon" href="../../web/favicon.ico" type="icon" />
<link rel="shortcut icon" href="../web/favicon.ico" type="icon" />

<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use kartik\nav\NavX;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<style>
    html, body {
        width: 100%;
        height: 100%;
        margin: 0px;
    }
    body {
        display: block;
    }
    #container {
        width: 100%;
        height: 100%;
        overflow: auto;
    }
    div {
        display: block;
    }
    #cPane {
         position: absolute;
         width: 20%;
         height: 100%;
         margin-left: 2px;
         margin-right: 2px;
    }
    #mapContainer {
        display: inline-block;
        position: absolute;
        top: 0;
        right: 0;
        width: 80%;
        height: 100%;
    }
    #tagContainer {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: #ffffff;
        overflow-y: scroll;
    }
</style>
