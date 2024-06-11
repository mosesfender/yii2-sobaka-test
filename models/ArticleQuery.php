<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Article]].
 *
 * @see Article
 */
class ArticleQuery extends ActiveQuery
{
    
    /**
     * {@inheritdoc}
     * @return Article[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
    
    /**
     * {@inheritdoc}
     * @return Article|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
