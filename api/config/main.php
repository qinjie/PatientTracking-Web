<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'   // v1 module
        ],
    ],
    'components' => [
//        'authManager' => [
//            'class' => 'common\components\PhpManager',
//            'defaultRoles' => ['user', 'manager', 'admin'],
//            # if need to configure following files outside default folder (rbac)
////            'itemFile' => 'app\api\data\items.php', //Default path to items.php
////            'assignmentFile' => 'app\api\data\assignments.php', //Default path to assignments.php
////            'ruleFile' => 'app\api\data\rules.php', //Default path to rules.php
//        ],
        'request' => [
            // Enable JSON Input
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'cookieValidationKey' => 'MXtBcX_ZOCJVA4g9MOz6JoHtUvNFgkv8',
        ],
        'response' => [
            'format' => 'json',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
        ],
        'log' => [
//            'traceLevel' => YII_DEBUG ? 3 : 0,
            'traceLevel' => 3,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'logFile' => '@app/runtime/logs/api-error.log'
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['warning'],
                    'logFile' => '@app/runtime/logs/api-warning.log'
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            // Add URL Rules for API
            'rules' => [
//                # API for Account
//                'GET <version:\w+>/account/login' => '<version>/account/login',
//                'GET <version:\w+>/account/logout-all-sessions' => '<version>/account/logout-all-sessions',
//                'GET <version:\w+>/account/logout-current-session' => '<version>/account/logout-current-session',
                # API for ActiveRecords
                ['class' => 'yii\rest\UrlRule', 'pluralize' => false,
                    'controller' => 'v1/quuppa-tag-info',
                    'extraPatterns' => [
                        'GET search' => 'search',
                    ],
                    'tokens' => [
                        # Keep 'id' for default CRUD action
                        '{id}' => '<id:\\w+>',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'pluralize' => false,
                    'controller' => 'v1/quuppa-tag-position',
                    'extraPatterns' => [
                        'GET search' => 'search',
                    ],
                    'tokens' => [
                        # Keep 'id' for default CRUD action
                        '{id}' => '<id:\\w+>',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'pluralize' => false,
                    'controller' => 'v1/resident-location',
                    'extraPatterns' => [
                        'GET search' => 'search',
                    ],
                    'tokens' => [
                        # Keep 'id' for default CRUD action
                        '{id}' => '<id:\\w+>',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'pluralize' => false,
                    'controller' => 'v1/tag',
                    'extraPatterns' => [
                        'GET search' => 'search',
                    ],
                    'tokens' => [
                        # Keep 'id' for default CRUD action
                        '{id}' => '<id:\\w+>',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'pluralize' => false,
                    'controller' => 'v1/floor-map',
                    'extraPatterns' => [
                        'GET search' => 'search',
                    ],
                    'tokens' => [
                        # Keep 'id' for default CRUD action
                        '{id}' => '<id:\\w+>',
                    ],
                ],
            ],
        ]
    ],
    'params' => $params,
];