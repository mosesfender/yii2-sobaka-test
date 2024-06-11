<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Class BaseController
 *
 * Базовый контроллер. В нём подключим авторизацию и аутентификацию. Остальные наследуем от него.
 *
 * @package app\controllers
 */
class BaseController extends Controller
{
    
    public function behaviors()
    {
        return [
            /* Настройки доступа ко всем действиям всех контроллеров. Их тут немного, поэтому можно и так. */
            /* Разрешения|роли в файлах @app/rbac под управлением components/RbacPhpManager.php */
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow'       => true,
                        'controllers' => ['default'],
                        'actions'     => ['index', 'error', 'login', 'logout', 'unserialize'],
                        'roles'       => ['?', '@']
                    ],
                    [
                        'allow'       => true,
                        'controllers' => ['article'],
                        'actions'     => ['list', 'read'],
                        'roles'       => ['readPost']
                    ],
                    [
                        'allow'       => true,
                        'controllers' => ['article'],
                        'actions'     => ['edit', 'upload-image'],
                        'roles'       => ['createPost', 'updatePost']
                    ]
                ]
            ]
        ];
    }
    
    public function beforeAction($action)
    {
        /* Устанавливаем языковую локализацию в соответствии со значением в куке, или русский по-умолчанию */
        \yii::$app->language = isset($_COOKIE['sobaka_lang']) ? $_COOKIE['sobaka_lang'] : 'ru-RU';
        return parent::beforeAction($action);
    }
    
}