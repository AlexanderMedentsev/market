<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m230813_181008_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'structure' => $this->string()->notNull(),
            'expiration' => $this->date()->notNull(),
            'image' => $this->string()->defaultValue('/images/default.png'),
            'category' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-category',
            '{{%product}}',
            'category',
            'category',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-category',
            '{{%product}}'
        );

        $this->dropTable('{{%product}}');
    }
}
