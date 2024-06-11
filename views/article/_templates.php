<?php

use yii\bootstrap5\ActiveForm;
use yii\web\View;
use app\models\ArticleBlocks as ab;

/**
 * @var $this View
 * @var $form ActiveForm
 */

foreach ([ab::BLOCK_TYPE_TEXT, ab::BLOCK_TYPE_CITATE, ab::BLOCK_TYPE_NOTE] as $type) {
    $script = sprintf('<script id="template-%s" type="text/x-tmpl">', $type);
    $modelClass = sprintf('\app\models\ArticleBlock%s', ucfirst($type));
    $blockModel = new $modelClass(['id' => '{%=o.id%}']);
    $script .= $this->render('_article_block', compact('blockModel', 'form'));
    $script .= '</script>';
    echo $script;
}