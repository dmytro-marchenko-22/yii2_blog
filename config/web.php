<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'class' => 'yii\web\Request',
            'cookieValidationKey' => 'yii2-blog-secret-key-2026-mobile-phones',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // Admin
                'admin/' => 'admin/index',
                
                // Category management (specific routes before general)
                'category/create' => 'category/create',
                'category/update/<id>' => 'category/update',
                'category/delete/<id>' => 'category/delete',
                'category/' => 'category/index',
                'category/<slug>/' => 'category/view',
                
                // Tag management (specific routes before general)
                'tag/create' => 'tag/create',
                'tag/update/<id>' => 'tag/update',
                'tag/delete/<id>' => 'tag/delete',
                'tag/' => 'tag/index',
                'tag/<slug>/' => 'tag/view',
                
                // Comment management
                'comment/create' => 'comment/create',
                'comment/delete/<id>' => 'comment/delete',
                
                // Post management (specific routes before general)
                'post/create' => 'post/create',
                'post/update/<id>' => 'post/update',
                'post/delete/<id>' => 'post/delete',
                'post/' => 'post/index',
                'post/<slug>/' => 'post/view',
                
                // Site
                'signup' => 'site/signup',
                'login' => 'site/login',
                'logout' => 'site/logout',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
