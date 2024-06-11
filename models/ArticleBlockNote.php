<?php

namespace app\models;

use yii\helpers\ArrayHelper;

class ArticleBlockNote extends ArticleBlocks
{
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            ['body', 'string',
             'max'     => 1000,
             'tooLong' => \yii::t('app',
                                  'The text volume should not exceed {max, number} {max, plural, one{character} other{characters}}.')],
            ['title', 'string',
             'max'     => 255,
             'tooLong' => \yii::t('app',
                                  'The text volume should not exceed {max, number} {max, plural, one{character} other{characters}}.')],
        ]);
    }
    
    public function init()
    {
        parent::init();
        $this->block_type = static::BLOCK_TYPE_NOTE;
    }
}