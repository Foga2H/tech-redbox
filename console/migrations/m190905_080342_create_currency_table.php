<?php

use common\models\Currency;
use yii\db\Expression;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%currency}}`.
 */
class m190905_080342_create_currency_table extends Migration
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

        $this->createTable(Currency::tableName(), [
            'id' => $this->primaryKey(),
            'cbr_id' => $this->string()->notNull(),
            'name' => $this->string(),
            'char_code' => $this->string(),
            'value' => $this->float()->notNull(),
            'date_create' => $this->timestamp()->defaultValue(new Expression('now()')),
            'date_update' => $this->timestamp()->defaultValue(null)
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Currency::tableName());
    }
}
