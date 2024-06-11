<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int         $id
 * @property string      $username
 * @property string      $password
 * @property string|null $authKey
 * @property string|null $accessToken
 * @property int         $role
 * @property int         $flags
 *
 * @property int         $isSuper
 * @property int         $isWriter
 * @property int         $isReader
 */
class User extends ActiveRecord implements IdentityInterface
{
    /* Роли пользователей в данной конструкции */
    const ROLE_SUPER  = 0x1;
    const ROLE_WRITER = 0x2;
    const ROLE_READER = 0x4;
    
    /* Флаги пользователя */
    const FLG_ENABLED = 0x1; // Пользователь может авторизоваться
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username'], 'string', 'max' => 32],
            [['password', 'authKey', 'accessToken'], 'string', 'max' => 255],
        ];
    }
    
    static function roles()
    {
        return [
            static::ROLE_SUPER  => \yii::t('app', 'Super'),
            static::ROLE_WRITER => \yii::t('app', 'Writer'),
            static::ROLE_READER => \yii::t('app', 'Reader'),
        ];
    }
    
    /**
     * Поиск пользователя по username.
     *
     * @param string $username // Должен быть уже отфильтрованным от грязи в LoginForm
     *
     * @return User|null
     */
    public static function findByUsername(string $username): ?User
    {
        return static::findOne(['username' => $username]);
    }
    
    public function validatePassword($password)
    {
        return \yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
    
    /** Role getters */
    
    public function getIsSuper(): int
    {
        return $this->role & static::ROLE_SUPER;
    }
    
    public function getIsWriter(): int
    {
        return $this->role & static::ROLE_WRITER;
    }
    
    public function getIsReader(): int
    {
        return $this->role & static::ROLE_READER;
    }
    
    public function getCanEdit()
    {
        return $this->flags & self::FLG_ENABLED && $this->role & self::ROLE_SUPER | self::ROLE_WRITER;
    }
    
    /** Implementation IdentityInterface methods */
    
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }
    
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getAuthKey()
    {
        return $this->authKey;
    }
    
    public function validateAuthKey($authKey)
    {
        return $this->authKey = $authKey;
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                try {
                    $this->authKey = \Yii::$app->getSecurity()->generateRandomString();
                } catch (Exception $e) {
                }
            }
            return true;
        }
        return false;
    }
}
