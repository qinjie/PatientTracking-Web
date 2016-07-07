<link rel="shortcut icon" href="../../web/main.ico" type="image/x-icon" />

<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

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

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
//    $menuItems = [
//        ['label' => 'Home', 'url' => ['/site/index']],
//    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
//        $menuItems[] = ['label' => 'Quuppa',
//            'items' => [
//                ['label' => 'Quuppa tag location', 'url' => ['quuppa-tag-position/index']],
//                ['label' => 'Quuppa tag info', 'url' => ['quuppa-tag-info/index']],
//            ]
//        ];
        $menuItems[] = ['label' => 'Humans',
            'items' => [
                ['label' => 'Resident', 'url' => ['resident/index']],
                ['label' => 'Next of kin', 'url' => ['nextofkin/index']],
                ['label' => 'Resident Relative', 'url' => ['resident-relative/index']],
                ['label' => 'Current Location', 'url' => ['resident-location/index']],
                ['label' => 'Location History', 'url' => ['resident-location-history/index']],
                ['label' => 'Tag', 'url' => ['tag/index']],
            ]
        ];
        $menuItems[] = ['label' => 'Floor',
            'items' => [
                ['label' => 'Floor', 'url' => ['floor/index']],
                ['label' => 'Marker', 'url' => ['marker/index']],
                ['label' => 'Floor map', 'url' => ['floor-map/index']],
                ['label' => 'Floor manager', 'url' => ['floor-manager/index']],
                ['label' => 'Alert area', 'url' => ['alert-area/index']],
                ['label' => 'Button', 'url' => ['button/index']],
            ]
        ];
//        $menuItems[] = ['label' => 'User',
//            'items' => [
//                ['label' => 'Index', 'url' => ['user/index']],
//                ['label' => 'User token', 'url' => ['user-token/index']],
//            ]
//        ];
        $menuItems[] = [
            'label' => 'Account (' . Yii::$app->user->identity->username . ')',
            'items' => [
                ['label' => 'Account',
                    'url' => ['site/account'],
                ],
                ['label' => 'Logout',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ],
            ],
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
    
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->name ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
