<?php

namespace app\models;

use yii\helpers\ArrayHelper;

class ArticleBlockText extends ArticleBlocks
{
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            ['body', 'string',
             'min'      => 2,
             'max'      => 1000,
             'tooLong'  => \yii::t('app',
                                   'The text volume should not exceed {max, number} {max, plural, one{character} other{characters}}.'),
             'tooShort' => \yii::t('app',
                                   'The text volume should not be less than {min, number} {min, plural, one{character} other{characters}}.'),
            
             'skipOnEmpty' => false,
            ]
        ]);
    }
    
    public function init()
    {
        parent::init();
        $this->block_type = static::BLOCK_TYPE_TEXT;
    }
    
    
}