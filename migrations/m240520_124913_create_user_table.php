<?php

use yii\db\Migration;
use app\models\User;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m240520_124913_create_user_table extends Migration
{
    
    
    /**
     * {@inheritdoc}
     * @throws \yii\base\Exception
     */
    public function up()
    {
        $this->createTable('{{%user}}', [
            'id'          => $this->primaryKey(),
            'username'    => $this->string(32)->notNull(),
            'password'    => $this->string(255)->notNull(),
            'authKey'     => $this->string(255)->null(),
            'accessToken' => $this->string(255),
            'role'        => $this->integer(11)->defaultValue(0),
            'flags'       => $this->integer(11)->defaultValue(0),
            'created_at'  => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at'  => 'DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);
        
        /* Сразу создадим суперадмина -u admin -p 123456 */
        (new User([
                      'username' => 'admin',
                      'password' => \yii::$app->getSecurity()->generatePasswordHash('123456'),
                      'authKey'  => \Yii::$app->getSecurity()->generateRandomString(),
                      'role'     => User::ROLE_SUPER,
                      'flags'    => User::FLG_ENABLED
                  ]))->save();
        
        /* Сразу создадим редактора -u writer -p 123456 */
        (new User([
                      'username' => 'writer',
                      'password' => \yii::$app->getSecurity()->generatePasswordHash('123456'),
                      'authKey'  => \Yii::$app->getSecurity()->generateRandomString(),
                      'role'     => User::ROLE_WRITER,
                      'flags'    => User::FLG_ENABLED
                  ]))->save();
        
        /* Сразу создадим читателя -u reader -p 123456 */
        (new User([
                      'username' => 'reader',
                      'password' => \yii::$app->getSecurity()->generatePasswordHash('123456'),
                      'authKey'  => \Yii::$app->getSecurity()->generateRandomString(),
                      'role'     => User::ROLE_READER,
                      'flags'    => User::FLG_ENABLED
                  ]))->save();
    }
    
    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
