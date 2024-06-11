<?php

use app\components\ActiveField;
use app\models\Article;
use yii\web\User;
use yii\web\View;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/**
 * @var View    $this
 * @var Article $model
 * @var User    $user
 */

$user = \yii::$app->user;

$this->title = \yii::t('app', $model->isNewRecord ? 'Create post' : 'Edit post');

$this->params['breadcrumbs'][] = ['label' => \yii::t('app', 'Posts'), 'url' => '/article/list'];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="container" is="article-form">
    <?php echo $this->render('_legend') ?>
    <?php echo $this->render('_form', compact('model', 'user')) ?>
</div>
