<?php

namespace app\models;

use Yii;
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
 */
class User extends ActiveRecord implements IdentityInterface
{
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
}
