<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id'           => 'basic',
    'name'         => 'Sobaka.Test',
    'basePath'     => dirname(__DIR__),
    'bootstrap'    => ['log'],
    'defaultRoute' => 'default/index',
    'language'     => 'en-US',
    //'language'     => 'ru-Ru',
    'aliases'      => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components'   => [
        'request'      => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '__sobaka',
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        'user'         => [
            'identityClass'   => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'default/error',
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'           => $db,
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                'article/<id:\d+>'      => 'article/read',
                'article/edit'          => 'article/edit',
                'article/edit/<id:\d+>' => 'article/edit',
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'kartik\base\BootstrapIconsAsset' => [
                    'class' => \app\assets\BootstrapIconAsset::class
                ]
            ]
        ],
        'i18n'         => [
            'translations' => [
                'yii' => [
                    'class'          => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath'       => '@app/messages',
                ],
            ],
        ],
        'authManager'  => [
            'class' => '\app\components\RbacPhpManager',
        ],
    ],
    'container'    => [
        'definitions' => [
            // Чуть-чуть изменяем вид флэш-сообщений об ошибках
            'app\components\ModelException' => [
                'wrap'     => '<ul class="model-errors">%s</li>',
                'itemWrap' => '<li>%s</li>'
            ],
            // Инпуты в форме больно громоздкие, уменьшим их чуть-чуть.
//            'yii\bootstrap5\ActiveField'    => [
//                'class'        => '\app\components\ActiveField',
//                'inputOptions' => ['class' => 'form-control form-control-sm']
//            ],
            // Модель иллюстаций к постам
            'app\models\Figure'             => [
                'storage'            => '@app/web/uploads', // Хранилище иллюстраций
                'urlPath'            => '/uploads', // URL путь к директориям файлов
                'storeDirNameMethod' => 0x8000, // Метод именования директории нового файла
            ]
        ],
    ],
    'params'       => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class'    => 'yii\debug\Module',
        'dataPath' => '@runtime/debug1',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
    
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class'      => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;

function prer($arr, $dump = false, $die = false)
{
    $trace = debug_backtrace();
    $cnt = count($trace);
    try {
        $_ = $cnt > 1 ? "{$trace[1]["class"]}::{$trace[1]["function"]}" : "";
        echo "<em style=\"color: #008de5;\">[{$trace[0]["line"]}] {$_}</em>";
    } catch (Exception $ex) {
    
    }
    echo "<pre>";
    $dump ? var_dump($arr) : print_r($arr);
    echo "</pre>";
    $die ? die(sprintf("Stoped on %s", date("d:m:Y H:i:s"))) : null;
}

function ql(\yii\db\Query $query, $die = false)
{
    prer($query->createCommand()->rawSql, 0, $die);
}
