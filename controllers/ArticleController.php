<?php

namespace app\controllers;

use app\models\Article;
use app\models\ArticleBlockCitate;
use app\models\ArticleBlocks;
use app\models\ArticleSearch;
use app\models\Figure;
use yii\base\UserException;
use yii\bootstrap5\ActiveForm;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\UploadedFile;

class ArticleController extends BaseController
{
    
    public function actionList()
    {
        $user = \yii::$app->user;
        $model = new ArticleSearch();
        return $this->render('list', compact('user', 'model'));
    }
    
    /**
     * @param int $id
     *
     * @return string
     * @throws UserException
     */
    public function actionRead(int $id)
    {
        $model = $this->getArticle((int) $id);
        return $this->render('read', compact('model'));
    }
    
    /**
     * Создание/редактирование поста
     *
     * @param int|null $id
     *
     * @return string
     * @throws UserException
     * @throws Exception
     */
    public function actionEdit(int $id = null)
    {
        if (!$id) {
            $model = new Article(['author' => \yii::$app->user->id]);
        } else {
            $model = $this->getArticle((int) $id);
        }
        
        if (\yii::$app->request->isPost) {
            //$model->scenario = Article::SCENARIO_UPDATE;
            $errors          = [];
            
            $transaction = Article::getDb()->beginTransaction();
            $model->load($postData = \yii::$app->request->post(), StringHelper::basename(get_class($model)));
            try {
                $model->save();
                if (is_array($model->errors) && count($model->errors)) {
                    $errors = ArrayHelper::merge($errors, $model->errors);
                }
    
                $figureModel = $model->figure ?? \yii::createObject(Figure::class);
                $figureModel->article_id = $model->id;
                $figureModel->uploadFile();
                if (is_array($figureModel->errors) && count($figureModel->errors)) {
                    $errors = ArrayHelper::merge($errors, $figureModel->errors);
                }
                $figureModel->save();
                $model->populateRelation('figure', $figureModel);
                
                $blocks = $postData[StringHelper::basename(ArticleBlocks::class)] ?? [];
                /* @var $blockModel ArticleBlocks */
                foreach ($blocks as $id => &$block) {
                    if (!isset($block['block_type'])) {
                        continue;
                    }
                    $modelClass = sprintf('\app\models\ArticleBlock%s', ucfirst($block['block_type']));
                    if ($block['id'] && ctype_digit($block['id'])) {
                        $blockModel = $modelClass::findById($block['id']);
                        $blockModel->setAttributes((array) $block, false);
                    } else {
                        ArrayHelper::remove($block, 'id');
                        $blockModel = new $modelClass($block);
                    }
                    $blockModel->art_id = $model->id;
                    $blockModel->save();
                    $block = $blockModel;
                    if (is_array($blockModel->errors) && count($blockModel->errors)) {
                        $errors = ArrayHelper::merge($errors, $blockModel->errors);
                    }
                }
                
                $model->populateRelation('articleBlocks', $blocks);
                
                if (count($errors)) {
                    $transaction->rollBack();
                } else {
                    $transaction->commit();
                    \yii::$app->response->redirect(Url::to(sprintf('/article/edit/%d', $model->id)));
                }
            } catch (\Exception $ex) {
                $transaction->rollBack();
                throw $ex;
            }
        }
        
        return $this->render('edit', compact('model'));
    }
    
    public function actionRemove()
    {
    
    }
    
    /**
     * @param int $id
     *
     * @return Article|null
     * @throws UserException
     */
    public function getArticle(int $id): ?Article
    {
        $result = Article::findOne(['id' => (int) $id]);
        if (!$result) {
            throw new UserException(\yii::t('app', 'The specified article was not found.'));
        }
        return $result;
    }
    
    public function beforeAction($action)
    {
        if ($action->id == 'upload-image') {
            \yii::$app->request->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
    
    
}
