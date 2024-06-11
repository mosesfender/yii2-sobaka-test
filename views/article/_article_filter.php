<?php

/*
 * Copyright © Sergey Siunov. 2024
 * email: <sergey@siunov.ru>
 */

use app\components\ActiveField;
use app\models\ArticleSearch;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\web\User;
use yii\web\View;

/**
 * @var $this  View
 * @var $user  User
 * @var $model ArticleSearch
 */

?>

<div class="container article-filter">
    <?php $form = ActiveForm::begin(
        [
            'method'                 => 'get',
            'action'                 => ['/article/list'],
            'layout'                 => ActiveForm::LAYOUT_DEFAULT,
            'enableClientValidation' => false,
            'enableAjaxValidation'   => false,
        ]
    ); ?>

    <div class="row row-cols-lg-3 row-cols-sm-2">
        <?= $form->field($model, 'title', ['options' => ['class' => 'col']])->textInput() ?>
        <?= $form->field($model, 'descr', ['options' => ['class' => 'col']])->textInput() ?>
        <div class="col">
            <label class="form-label" for="sort"><?= \yii::t('app', 'Sort'); ?></label>
            <?= Html::dropDownList('sort', \yii::$app->request->get('sort'),
                                   [
                                           'title'  => \yii::t('app', 'Title A-Z'),
                                           '-title' => \yii::t('app', 'Title Z-A'),
                                           'created_at'  => \yii::t('app', 'Created at 0-9'),
                                           '-created_at' => \yii::t('app', 'Created at 9-0'),
                                           'updated_at'  => \yii::t('app', 'Updated at 0-9'),
                                           '-updated_at' => \yii::t('app', 'Updated at 9-0'),
                                   ], ['class' => 'form-control']);
            ?>
        </div>
    </div>
    <div class="row justify-content-center">
        <?= Html::submitButton(\yii::t('app', 'Search'),
                               ['type' => 'submit', 'class' => 'col-lg-1 col-mb-2 btn btn-primary btn-sm mb-2 me-2']) ?>
        <?= Html::resetButton(\yii::t('app', 'Reset'),
                              ['type' => 'reset', 'class' => 'col-lg-1 col-mb-2 btn btn-outline-primary btn-sm mb-2']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>
