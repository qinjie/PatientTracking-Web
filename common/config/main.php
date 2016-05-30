<?php
return [
    'timeZone' => 'Asia/Singapore',
    'name' => 'Patient Tracking',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
//            'enableStrictParsing' => true,
            'rules' => array(
                '<_a:(login|logout|signup|confirm-email|change-email|change-password|reset-password-request|reset-password)>' => 'site/<_a>',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>' => '<controller>/index',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
//            'defaultRoles' => ['user', 'manager', 'admin'],
            # if need to configure following files outside default folder (rbac)
//            'itemFile' => 'app\api\data\items.php', //Default path to items.php
//            'assignmentFile' => 'app\api\data\assignments.php', //Default path to assignments.php
//            'ruleFile' => 'app\api\data\rules.php', //Default path to rules.php
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=patient_tracking',
            'username' => 'sa',
            'password' => 'abcd1234',
            'charset' => 'utf8',
        ],
        'log' => [
//            'traceLevel' => YII_DEBUG ? 3 : 0,
            'traceLevel' => 3,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'logFile' => '@app/runtime/logs/other-error.log'
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['warning'],
                    'logFile' => '@app/runtime/logs/other-warning.log'
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'eceiot.test@gmail.com',
                'password' => 'qw1234er',
                'port' => '587',
                'encryption' => 'tls',
            ],
            //set this property to false to send mails to real email addresses
            //comment the following array to send mail using php's mail function
            'useFileTransport' => false,
            'fileTransportPath' => '@common/runtime',
        ],
    ],
    // To add Gii to common
    'bootstrap' => ['gii'],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
        ],
    ],
];
