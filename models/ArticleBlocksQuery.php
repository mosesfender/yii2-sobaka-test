<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the ActiveQuery class for [[ArticleBlocks]].
 *
 * @see ArticleBlocks
 */
class ArticleBlocksQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return ArticleBlocks[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
    
    /**
     * {@inheritdoc}
     * @return ArticleBlocks|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    
    /**
     * Подменяем метод трейта для публикации моделей в соответствии с типом блока.
     * @param array $rows
     *
     * @return array|ActiveRecord[]
     */
    protected function createModels($rows)
    {
        if ($this->asArray) {
            return $rows;
        } else {
            $models = [];
            foreach ($rows as $row) {
                /* @var $class ArticleBlocks */
                $class = sprintf('\app\models\ArticleBlock%s', ucfirst($row['block_type']));
                $model = $class::instantiate($row);
                $modelClass = get_class($model);
                $modelClass::populateRecord($model, $row);
                $models[] = $model;
            }
            return $models;
        }
    }
    
    
}
