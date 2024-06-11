<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%article}}`.
 */
class m240521_092141_create_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%article}}', [
            'id'         => $this->primaryKey(),
            'title'      => $this->string(255)->notNull()->comment('Заголовок поста'),
            'descr'      => $this->text()->notNull()->comment('Описание поста'),
            'author'     => $this->integer(11)->notNull()->comment('ID автора из таблицы user'),
            'flags'      => $this->integer(11)->defaultValue(0)->comment('Битовые флаги модели'),
            'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP'
        ], 'COMMENT="Список постов"');
        
        $this->createTable('{{%article_blocks}}', [
            'id'         => $this->primaryKey(),
            'art_id'     => $this->integer(11)->notNull()->comment('ID поста, внешний ключ'),
            'block_type' => "enum ('text', 'citate', 'note') NOT NULL COMMENT 'Тип блока'",
            'title'      => $this->text()->null()->comment('Заголовок блока'),
            'body'       => $this->text()->null()->comment('Тело блока'),
            'author'     => $this->text()->null()->comment('Подпись'),
            'sort'       => $this->integer(11)->notNull()->comment('Очерёдность блока в статье'),
            'flags'      => $this->integer(11)->defaultValue(0)->comment('Битовые флаги модели')
        ], 'COMMENT="Блоки постов"');
        
        $this->addForeignKey('FK_article_id_article_blocks', 'article_blocks',
                             'art_id', 'article', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('UIDX_block_art', 'article_blocks', ['id', 'art_id'], true);
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_article_id_article_blocks', 'article_blocks');
        $this->dropIndex('UIDX_block_art', 'article_blocks');
        $this->dropTable('{{%article_blocks}}');
        $this->dropTable('{{%article}}');
    }
}
