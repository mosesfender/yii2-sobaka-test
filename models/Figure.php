<?php

namespace app\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "figure".
 *
 * @property int         $id
 * @property int         $article_id         ID поста из таблицы article
 * @property string      $original_file_name Оргинальное имя файла
 * @property string      $stored_file_name   Имя файла в хранилище
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null    $flags
 *
 * @property Article     $article
 */
class Figure extends ActiveRecord
{
    use FigureTrait;
    
    /**
     * Константы-обозначения метода формирования имени директории файла в хранилище файлов.
     * См. FigureTrait::getFigurePath()
     */
    const FM_STORE_BY_YEAR   = 0x1000;
    const FM_STORE_BY_MONTH  = 0x2000;
    const FM_STORE_BY_DAY    = 0x4000;
    const FM_STORE_BY_HOUR   = 0x8000;
    const FM_STORE_BY_MINUTE = 0x10000;
    
    const SCENARIO_DEFAULT = 'default';
    const SCENARIO_UPDATE  = 'update';
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'figure';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_id', 'original_file_name', 'stored_file_name'], 'required'],
            [['article_id', 'flags'], 'integer'],
            [['original_file_name', 'stored_file_name'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['article_id'], 'exist',
             'skipOnError'     => true,
             'targetClass'     => Article::class,
             'targetAttribute' => ['article_id' => 'id']],
            [ // Правило для загружаемой иллюстрации
              'figureFile', 'image',
              'extensions' => 'png, jpg',
              'minWidth'   => 1200,
              //'maxSize'    => 1024 * 700,
              //'on'         => Figure::SCENARIO_UPDATE,
              'when'       => function (self $model) {
                  return $model->figureFile instanceof UploadedFile;
              }
            ]
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                 => Yii::t('app', 'ID'),
            'article_id'         => Yii::t('app', 'ID поста из таблицы article'),
            'original_file_name' => Yii::t('app', 'Оргинальное имя файла'),
            'stored_file_name'   => Yii::t('app', 'Имя файла в хранилище'),
            'created_at'         => Yii::t('app', 'Created At'),
            'updated_at'         => Yii::t('app', 'Updated At'),
            'flags'              => Yii::t('app', 'Flags'),
            'figureFile'         => Yii::t('app', 'figureFile'),
        ];
    }
    
    /**
     * Gets query for [[Article]].
     *
     * @return ActiveQuery
     */
    public function getArticle(): ActiveQuery
    {
        return $this->hasOne(Article::class, ['id' => 'article_id']);
    }
    
    /**
     * {@inheritdoc}
     * @return FigureQuery the active query used by this AR class.
     */
    public static function find(): FigureQuery
    {
        return new FigureQuery(get_called_class());
    }
    
    /**
     * Перекрытие метода получения образца.
     * В предке инстант получается через new, что не позволяет получать конфигурацию из DI-контейнера.
     * Эта порча преследует почти все классы в фреймворке, надо бы создателям обратить на это внимание.
     *
     * В этом методе создаём объект модели через DI. Это нужно, в частности, при получении
     *  related-модели в модели Article (см. \yii\db\ActiveQueryTrait::createModels)
     *  для использования конфигурации класса Figure в секции конфига container.
     *
     * @param array $row
     *
     * @return object
     * @throws InvalidConfigException
     */
    public static function instantiate($row): object
    {
        return \yii::createObject(static::class);
    }
    
    
}
