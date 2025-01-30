<?php


$params = array_merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);


$config = [
    'id' => 'basic',
    'name' => 'SKPI',
    'language' => 'en',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'app\components\Aliases'],
    'modules' => [
       'gridview' =>  [
            'class' => '\kartik\grid\Module'
            // enter optional module parameters below - only if you need to  
            // use your own export download action or custom translation 
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ],
     
    ],
    'aliases' => [
        '@bower' => '@vendor/yidas/yii2-bower-asset/bower',
        // '@bower' => '@vendor/bower',
        '@npm'   => '@app/../node_modules',
    ],
    'timeZone' => 'Asia/Jakarta',
    'components' => [
        'apiManager' => [
            'class' => 'virgantara\components\ApiManager',
            'api_baseurl' => $params['api_baseurl'],
            'client_token' => $params['client_token'],
            'timeout' => 60
        ],
        'aplikasi' => [
            'class' => 'virgantara\components\AplikasiAuth',
            'baseurl' => $params['oauth']['baseurl'], 
        ],
        'tokenManager' => [
            'class' => 'virgantara\components\TokenManager',
        ],
        'oauth2' => [
            'class' => 'virgantara\components\OAuth2Client',
            'tokenValidationUrl' => $params['oauth']['baseurl'], // Endpoint for token validation
            'tokenRefreshUrl' => $params['oauth']['baseurl'],
            'client_id' => $params['oauth']['client_id'],
            'client_secret' => $params['oauth']['client_secret'],
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => '884298860720-7hg40fqlab57mo5r9cqiciunn5l7t3c5.apps.googleusercontent.com',
                    'clientSecret' => 'GIbrzx1g4flU2tFBYxcDYJgg'
                ]
            ]
        ],
        // 'pdf' => [
        //     'class' => \kartik\mpdf\Pdf::classname(),
        //     'format' => \kartik\mpdf\Pdf::FORMAT_A4,
        //     'orientation' => \kartik\mpdf\Pdf::ORIENT_PORTRAIT,
        //     'destination' => \kartik\mpdf\Pdf::DEST_BROWSER,
        //     // refer settings section for all configuration options
        // ],
        'cart' => [
            'class' => 'yii2mod\cart\Cart',
            // you can change default storage class as following:
            'storageClass' => [
                'class' => 'yii2mod\cart\storage\DatabaseStorage',
                // you can also override some properties 
                'deleteIfEmpty' => true
            ]
        ],
        
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'currencyCode' => 'IDR',
            'dateFormat' => 'php:d-m-Y',
            'datetimeFormat' => 'php:d-m-Y H:i:s'
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'bismillah',
        ],
        // you can set your theme here - template comes with: 'light' and 'dark'
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@webroot/themes/ace/views'
                ],
                'baseUrl' => '@web/themes/ace',
                'basePath' => '@web/themes/ace',
            ],
        ],
        'assetManager' => [
            'assetMap' => [
                'jquery.js' => '@web/themes/ace/js/jquery-2.1.4.min.js',
                'jquery.ui.js' => '@web/themes/ace/js/jquery-ui.min.js',
                'bootstrap.js' => '@web/themes/ace/js/bootstrap.min.js'
            ],
            'bundles' => [
                // we will use bootstrap css from our theme
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [], // do not use yii default one
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'user' => [
            'identityClass' => 'app\models\UserIdentity',
            'enableAutoLogin' => true,
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
            'cookieParams' => ['lifetime' => 7 * 24 *60 * 60],
            'timeout' => 60 * 60 * 24 * 7, //session expire
            'useCookies' => true,

        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            // 'cache' => 'cache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. 
            // You have to set 'useFileTransport' to false and configure a transport for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => $params['mail'], 
    
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
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/translations',
                    'sourceLanguage' => 'en',
                ],
                'yii' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/translations',
                    'sourceLanguage' => 'en'
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = ['class' => 'yii\debug\Module'];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'newFileMode' => 0644,
        'newDirMode' => 0755,      
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*'],  
        'generators' => [ //here
            'crud' => [ // generator name
                'class' => 'yii\gii\generators\crud\Generator', // generator class
                'templates' => [ //setting for out templates
                    'myCrud' => '@app/template/crud/default', // template name => path to template
                ]
            ]
        ],
    ];
}

return $config;
