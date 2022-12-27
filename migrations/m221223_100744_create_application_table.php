<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%application}}`.
 */
class m221223_100744_create_application_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%application}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(128)->notNull(),
            'content' => $this->text()->notNull(),
            'create_time' => $this->integer()->notNull(),
            'update_time' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'FK_application_author',
            '{{%application}}',
            'author_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );

        $this->insert('{{%application}}', [
            'title' => 'Test Application',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'create_time' => time(),
            'update_time' => time(),
            'author_id' => 1
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_application_author', '{{%application}}');
        $this->dropTable('{{%application}}');
    }
}
