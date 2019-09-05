<?php

use yii\db\Expression;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m190905_101908_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'photo_url' => $this->text(),
            'vendor_code' => $this->string(),
            'price' => $this->double()->notNull(),
            'date_create' => $this->timestamp()->defaultValue(new Expression('now()')),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }
}
