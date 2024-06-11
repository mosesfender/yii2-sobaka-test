<?php

use app\models\ArticleBlocks;
use yii\bootstrap5\ActiveForm;
use yii\web\View;

/**
 * Блок текст
 *
 * @var View          $this
 * @var ArticleBlocks $blockModel
 * @var ActiveForm    $form
 */

echo $form->field($blockModel, 'body')
    ->textarea(['name' => $blockModel->getInputName('body'), 'max' => 500, 'tooLong' => 'Объём текста не должен превышать 500 символов.'])
    ->label(false);
echo $form->field($blockModel, 'author', ['options' => ['class' => 'col-md-3 justify-content-end']])
    ->textInput(['name' => $blockModel->getInputName('author'), 'max' => 255, 'tooLong' => 'Объём текста не должен превышать 255 символов.']);