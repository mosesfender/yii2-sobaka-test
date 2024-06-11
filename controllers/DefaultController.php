<?php

namespace app\controllers;

use app\components\ModelException;
use app\models\LoginForm;
use yii\web\Response;

class DefaultController extends BaseController
{
    public function actions()
    {
        return [
            'error' => ['class' => 'yii\web\ErrorAction'],
        ];
    }
    
    
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!\yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new LoginForm();
        try {
            if ($model->load(\yii::$app->request->post()) && $model->login()) {
                return $this->goBack();
            }
        } catch (ModelException $ex) {
            \yii::$app->getSession()->setFlash('error', $ex->toString());
        }
        
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    
    public function actionLogout()
    {
        \yii::$app->user->logout();
        return $this->goHome();
    }
    
}