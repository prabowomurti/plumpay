<?php

use yii\db\Migration;

/**
 * Handles adding balance to table `user`.
 */
class m170311_110001_add_balance_column_to_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'balance', $this->integer()->defaultValue(0));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'balance');
    }
}
