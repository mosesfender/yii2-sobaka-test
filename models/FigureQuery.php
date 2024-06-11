<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Figure]].
 *
 * @see Figure
 */
class FigureQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Figure[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Figure|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
