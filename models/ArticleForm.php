<?php

namespace app\models;

use yii\base\Model;

class ArticleForm extends Model
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    
    /**
     * @var Article|null
     */
    public ?Article $article      = null;
    
    /**
     * @var ArticleBlocks[]
     */
    public array    $articleBlocs = [];
    
    public function rules()
    {
        return [
        
        ];
    }
    
    public function load($data, $formName = null)
    {
        $result  = false;
        $errors  = [];
        $article = parent::load($data['Article'], $formName);
    }
    
}