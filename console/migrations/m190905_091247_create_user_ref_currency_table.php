<?php

use common\models\Currency;
use common\models\User;
use common\models\UserRefCurrency;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_ref_currency}}`.
 */
class m190905_091247_create_user_ref_currency_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(UserRefCurrency::tableName(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'currency_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-user_ref_currency-user_id',
            UserRefCurrency::tableName(),
            'user_id',
            User::tableName(),
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-user_ref_currency-currency_id',
            UserRefCurrency::tableName(),
            'currency_id',
            Currency::tableName(),
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-user_ref_currency-[user_id-currency_id]',
            UserRefCurrency::tableName(),
            ['user_id', 'currency_id'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(UserRefCurrency::tableName());
    }
}
