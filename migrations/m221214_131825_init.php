<?php

use yii\db\Migration;

/**
 * Class m221214_131825_init
 */
class m221214_131825_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(128)->notNull(),
            'password' => $this->string(128)->notNull(),
            'email' => $this->string(128)->unique()->notNull(),
            'role_id' => $this->integer()->notNull(),
            'auth_key' => $this->string()->notNull(),
            'access_token' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%role}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'FK_user_role',
            '{{%user}}',
            'role_id',
            '{{%role}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );

        $this->insert('{{%role}}', ['name' => 'Support department employee']);
        $this->insert('{{%role}}', ['name' => 'Dispatcher']);
        $this->insert('{{%role}}', ['name' => 'Subscriber']);

        $this->insert('{{%user}}', [
            'username' => 'demo',
            'password' => '$2a$10$JTJf6/XqC94rrOtzuF397OHa4mbmZrVTBOQCmYD9U.obZRUut4BoC',
            'email' => 'webmaster@example.com',
            'role_id' => 3,
            'auth_key' => Yii::$app->security->generateRandomString(),
            'access_token' => Yii::$app->security->generateRandomString()
        ]);

        $this->insert('{{%user}}', [
            'username' => 'admin',
            'password' => '$2a$10$JTJf6/XqC94rrOtzuF397OHa4mbmZrVTBOQCmYD9U.obZRUut4BoC',
            'email' => 'admin@example.com',
            'role_id' => 1,
            'auth_key' => Yii::$app->security->generateRandomString(),
            'access_token' => Yii::$app->security->generateRandomString()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_user_role', '{{%user}}');
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%role}}');
    }
}
