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
        ]);
        
        /* Сразу создадим суперадмина -u admin -p 123456 */
        (new User([
                      'username' => 'admin',
                      'password' => \yii::$app->getSecurity()->generatePasswordHash('123456')
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
