<?php
/*
 * Copyright © Sergey Siunov. 2024
 * email: <sergey@siunov.ru>
 */

namespace app\models;

use http\Url;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * Расширяет модели изображений для работы с физическими директориями и файлами.
 */
trait FigureTrait
{
    /**
     * Хранилище файлов.
     * Модель берёт на себя обязанность создавать и поддерживать
     * пути хранения файлов, использующих данную модель.
     * Значение переменной см. в конфиге в разделе <container>
     *
     * @var string
     */
    public string $storage = '';
    
    /**
     * URL путь к хранилищу файлов
     *
     * @var string
     */
    public string $urlPath = '/';
    
    /**
     * Определяет, каким образом будут именоваться в хранилище директории для вновь создаваемых файлов.
     * См. константы <self::FM_STORE_BY_[...]>
     *
     * @default 0x1000 Файл хранится в директории с именем <год_создания_файла>
     * @var int
     */
    public int $storeDirNameMethod = Figure::FM_STORE_BY_YEAR;
    
    /**
     * Загружаемая иллюстрация
     */
    public UploadedFile|string|null $figureFile = '';
    
    /**
     * @throws Exception
     */
    public function uploadFile()
    {
        $this->figureFile = UploadedFile::getInstance($this, 'figureFile');
        if ($this->figureFile instanceof UploadedFile && $this->validate('figureFile')) {
            $this->stored_file_name = $this->stored_file_name
                ?? sprintf('%s.%s', md5($this->figureFile->baseName), $this->figureFile->extension);
            $this->original_file_name = $this->figureFile->name;
            if ($this->isNewRecord) {
                /* Если запись новая, установим способ именования дирректории файла из настроек модели.
                Если запись уже существующая и файл уже лежит, то менять нельзя, ибо потеряется. */
                $this->setStoreDirNameMethod($this->storeDirNameMethod);
            }
            $absName = $this->getFigureFileName($this->stored_file_name);
            $dir = pathinfo($absName, PATHINFO_DIRNAME);
            if (!is_dir($dir)) {
                FileHelper::createDirectory($dir);
            }
            $this->figureFile->saveAs($absName, false);
        }
    }
    
    /**
     * Определяет название директории файла в хранилище.
     * Название формируется из времени в соответствии с форматированием date().
     * Если это новый файл, время берётся текущее, а входной параметр $flag - self::$storeDirNameMethod.
     * В случае если это уже существующий файл, имя директории
     * формируется из времени создания записи, поле $this->created_at.
     *s
     *
     * @return string|void
     */
    public function getFigurePath()
    {
        $date = $this->created_at
            ? \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $this->created_at)->getTimestamp()
            : \DateTimeImmutable::createFromMutable(new \DateTime(timezone: new \DateTimeZone('Europe/Moscow')))->getTimestamp();
        $flag = $this->isNewRecord ? $this->storeDirNameMethod : $this->flags;
        
        if ($flag & Figure::FM_STORE_BY_YEAR) {
            return date('Y', $date);
        } elseif ($flag & Figure::FM_STORE_BY_MONTH) {
            return date('Ym', $date);
        } elseif ($flag & Figure::FM_STORE_BY_DAY) {
            return date('Ymd', $date);
        } elseif ($flag & Figure::FM_STORE_BY_HOUR) {
            return date('YmdH', $date);
        } elseif ($flag & Figure::FM_STORE_BY_MINUTE) {
            return date('YmdHi', $date);
        }
    }
    
    public function setStoreDirNameMethod(int $method): self
    {
        $this->storeDirNameMethod = $method;
        $this->flags
            = $this->flags & ~(Figure::FM_STORE_BY_YEAR | Figure::FM_STORE_BY_MONTH | Figure::FM_STORE_BY_DAY | Figure::FM_STORE_BY_HOUR | Figure::FM_STORE_BY_MINUTE);
        $this->flags |= $this->storeDirNameMethod;
        return $this;
    }
    
    public function getFigureFileName($filename = null): string
    {
        $filename = $filename ?? $this->stored_file_name;
        return sprintf('%s/%s/%s', \yii::getAlias($this->storage), $this->getFigurePath(), $filename);
    }
    
    public function getFigureUrl($absolute = false): string
    {
        if (empty($this->stored_file_name)) {
            return '';
        }
        $result = sprintf('%s/%s/%s', $this->urlPath, $this->getFigurePath(), $this->stored_file_name);
        return \yii\helpers\Url::to($result, $absolute);
    }
}