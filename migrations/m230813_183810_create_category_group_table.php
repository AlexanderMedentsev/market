<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category_group}}`.
 */
class m230813_183810_create_category_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category_group}}', [
            'id' => $this->primaryKey(),
            'id_category' => $this->integer()->notNull(),
            'id_group' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-id_category',
            '{{%category_group}}',
            'id_category',
            'category',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-id_group',
            '{{%category_group}}',
            'id_group',
            'group',
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
            'fk-id_category',
            '{{%category_group}}'
        );

        $this->dropForeignKey(
            'fk-id_group',
            '{{%category_group}}'
        );

        $this->dropTable('{{%category_group}}');
    }
}
