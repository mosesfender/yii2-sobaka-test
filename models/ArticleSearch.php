<?php
/*
 * Copyright © Sergey Siunov. 2024
 * email: <sergey@siunov.ru>
 */

namespace app\models;

use yii\data\ActiveDataProvider;

class ArticleSearch extends Article
{
    public string $sort = 'id';
    
    public function search($data = [])
    {
        $this->load($data);
        
        $query = static::find();
    
        $result =  new ActiveDataProvider(
            [
                'query' => $query,
                'sort'  => [
                    'defaultOrder' => [
                        'created_at' => SORT_DESC,
                        'title'      => SORT_ASC,
                    ]
                ],
            ]
        );

        $query
            ->andFilterWhere(['RLIKE', 'title', $this->title])
        ;
        
        return $result;
    }
}

