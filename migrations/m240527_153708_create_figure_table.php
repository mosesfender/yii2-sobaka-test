<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%figure}}`.
 */
class m240527_153708_create_figure_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%figure}}', [
            'id'                 => $this->primaryKey(),
            'article_id'         => $this->integer(11)->notNull()->comment('ID поста из таблицы article'),
            'original_file_name' => $this->text()->notNull()->comment('Оргинальное имя файла'),
            'stored_file_name'   => $this->text()->notNull()->comment('Имя файла в хранилище'),
            'created_at'         => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at'         => 'DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP',
            'flags'              => $this->integer(11)->defaultValue(0)
        ], 'COMMENT="Список иллюстраций к постам"');
        
        $this->addForeignKey('FK_article_id_figure_id', 'figure', 'article_id',
                             'article', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('IDX_article_id', 'figure', 'article_id');
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_article_id_figure_id', 'figure');
        $this->dropIndex('IDX_article_id', 'article');
        $this->dropTable('{{%figure}}');
    }
}
