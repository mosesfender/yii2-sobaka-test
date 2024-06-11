<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\StringHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "article".
 *
 * @property int             $id
 * @property string          $title       Заголовок поста
 * @property string          $descr       Описание поста
 * @property int             $author      ID автора из таблицы user
 * @property int|null        $flags       Битовые флаги модели
 * @property double          $created_at  Время создания
 * @property double          $updated_at  Время изменения
 *
 * @property Figure          $figure      Иллюстрация
 * @property ArticleBlocks[] $articleBlocks
 */
class Article extends ActiveRecord
{
    
    const SCENARIO_DEFAULT = 'default';
    const SCENARIO_UPDATE  = 'update';
    
    /**
     * Загружаемая иллюстрация
     */
    public UploadedFile|string|null $figureFile = '';
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'descr', 'author'], 'required'],
            [['descr'], 'string', 'min' => 10, 'max' => 500],
            [['author', 'flags'], 'integer'],
            ['title', 'string', 'min' => 2, 'max' => 255],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'ID'),
            'title'      => Yii::t('app', 'Title'),
            'descr'      => Yii::t('app', 'Description'),
            'figure'     => Yii::t('app', 'Figure'),
            'author'     => Yii::t('app', 'Author'),
            'flags'      => Yii::t('app', 'Flags'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
            'sort'       => Yii::t('app', 'Sort'),
        ];
    }
    
    /**
     * @return ActiveQuery|ArticleBlocksQuery
     */
    public function getArticleBlocks()
    {
        return $this->hasMany(ArticleBlocks::class, ['art_id' => 'id'])
            ->indexBy('id')
            ->orderBy('sort');
    }
    
    /**
     * @return ActiveQuery
     */
    public function getFigure()
    {
        return $this->hasOne(Figure::class, ['article_id' => 'id']);
    }
    
    /**
     * {@inheritdoc}
     * @return ArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticleQuery(get_called_class());
    }
    
}
