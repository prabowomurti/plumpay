<?php

use yii\db\Migration;

/**
 * Handles the creation of table `transfer`.
 */
class m170311_232437_create_transfer_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $table_name = 'transfer';
        $this->createTable($table_name, [
            'id'             => $this->primaryKey(),
            'source_id'      => $this->integer(),
            'destination_id' => $this->integer(),
            'amount'         => $this->integer()->notNull()->defaultValue(1),
            'created_at'     => $this->integer()->notNull(),
            'updated_at'     => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'transfer_to_source', // => foreign key name
            $table_name, //          => current table
            'source_id', //          => current table field
            'user', //               => reference table
            'id', //                 => reference table field
            'SET NULL', //           => ON DELETE
            'CASCADE' //             => ON UPDATE
        );

        $this->addForeignKey(
            'transfer_to_destination', // => foreign key name
            $table_name, //               => current table
            'destination_id', //          => current table field
            'user', //                    => reference table
            'id', //                      => reference table field
            'SET NULL', //                => ON DELETE
            'CASCADE' //                  => ON UPDATE
        );

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('transfer_to_source', 'transfer');
        $this->dropForeignKey('transfer_to_destination', 'transfer');
        $this->dropTable('transfer');
    }
}
