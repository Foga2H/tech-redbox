<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m190905_073009_add_role_user_table
 */
class m190905_073009_add_role_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            User::tableName(),
            'role',
            $this->integer()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(User::tableName(), 'role');
    }
}
