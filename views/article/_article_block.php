<?php

use app\models\ArticleBlocks;
use yii\bootstrap5\ActiveForm;
use yii\web\View;

/**
 * Общая обёртка для всех типов блоков
 *
 * @var View          $this
 * @var ArticleBlocks $blockModel
 * @var ActiveForm    $form
 */

?>

<div is="article-block">
    <div class="lever">
    
    </div>
    
    <?php
    echo $form->field($blockModel, 'id', ['template' => '{input}'])
        ->hiddenInput(['name' => $blockModel->getInputName('id')])->label(false);
    echo $form->field($blockModel, 'block_type', ['template' => '{input}'])
        ->hiddenInput(['name' => $blockModel->getInputName('block_type')])->label(false);
    echo $form->field($blockModel, 'sort', ['template' => '{input}'])
        ->hiddenInput(['name' => $blockModel->getInputName('sort')])->label(false);
    echo $form->field($blockModel, 'flags', ['template' => '{input}'])
        ->hiddenInput(['name' => $blockModel->getInputName('flags')])->label(false);
    /**
     * Тип блока — одно из значений поля ENUM (см. константы ArticleBlocks::BLOCK_TYPE_).
     * Шаблоны соответствующих блоков названы _article_block_<суффикс-тип блока>
     */
    echo $this->render(sprintf('_article_block_%s', $blockModel->block_type), compact('blockModel', 'form'));
    ?>
</div>
