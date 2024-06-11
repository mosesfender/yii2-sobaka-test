<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\StringHelper;
use yii\web\View;

/**
 * This is the model class for table "article_blocks".
 *
 * @property int         $id
 * @property int         $art_id     ID поста, внешний ключ
 * @property string      $block_type Тип блока
 * @property string|null $title      Заголовок блока
 * @property string|null $body       Тело блока
 * @property string|null $author     Подпись
 * @property int|null    $flags      Битовые флаги модели
 *
 * @property Article     $art
 */
class ArticleBlocks extends ActiveRecord
{
    /* Констнты типа блока. Значения предустановлены в ENUM поле article_blocks.block_type */
    const BLOCK_TYPE_TEXT   = 'text';
    const BLOCK_TYPE_CITATE = 'citate';
    const BLOCK_TYPE_NOTE   = 'note';
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_blocks';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['art_id', 'block_type'], 'required'],
            [['art_id', 'flags', 'sort'], 'integer'],
            [['block_type'], 'string'],
            [['art_id'], 'exist',
             'skipOnError'     => true,
             'targetClass'     => Article::class,
             'targetAttribute' => ['art_id' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'ID'),
            'art_id'     => Yii::t('app', 'Art ID'),
            'block_type' => Yii::t('app', 'Block Type'),
            'title'      => Yii::t('app', 'Title'),
            'body'       => Yii::t('app', 'Body'),
            'author'     => Yii::t('app', 'Author'),
            'flags'      => Yii::t('app', 'Flags'),
        ];
    }
    
    
    public function init()
    {
        parent::init();
        $this->flags = 0;
    }
    
    /**
     * Gets query for [[Art]].
     *
     * @return ActiveQuery|ArticleQuery
     */
    public function getArt()
    {
        return $this->hasOne(Article::class, ['id' => 'art_id']);
    }
    
    /**
     * {@inheritdoc}
     * @return ArticleBlocksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticleBlocksQuery(get_called_class());
    }
    
    /**
     * @param int $id
     *
     * @return ArticleBlocks|null
     */
    public static function findById(int $id): ?ArticleBlocks
    {
        return self::findOne(['id' => (int)$id]);
    }
    
    public function getInputName($attribute)
    {
        return StringHelper::basename(self::class) . "[$this->id]" . "[$attribute]";
    }
    
    /**
     * Возвращает строковые представления типов блоков.
     * Если на вход подаётся значение, то возвращает только его представление.
     * Иначе возвращает весь список.
     *
     * @param string|null $type
     *
     * @return string|string[]
     */
    static function getStringBlockType(string $type = null)
    {
        $result = [
            self::BLOCK_TYPE_TEXT   => 'Текст',
            self::BLOCK_TYPE_CITATE => 'Цитата',
            self::BLOCK_TYPE_NOTE   => 'Заметка',
        ];
        if ($type) {
            return $result[$type];
        }
        return $result;
    }
}
