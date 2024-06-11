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

echo $form->field($blockModel, 'title')
    ->textInput(['name' => $blockModel->getInputName('title'), 'max' => 255, 'tooLong' => 'Объём текста не должен превышать 255 символов.']);
echo $form->field($blockModel, 'body')
    ->textarea(['name' => $blockModel->getInputName('body'),  'max' => 1000, 'tooLong' => 'Объём текста не должен превышать 1000 символов.'])
    ->label(false);
