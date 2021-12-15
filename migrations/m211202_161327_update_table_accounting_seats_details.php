<?php

use yii\db\Migration;

class m211202_161327_update_table_accounting_seats_details extends Migration
{
    public function up()
    {
        $this->createTable('{{%accounting_seats_details}}', [
            'id' => $this->bigPrimaryKey(),
            'accounting_seat_id' => $this->bigInteger()->notNull(),
            'chart_account_id' => $this->bigInteger()->notNull(),
            'debit' => $this->decimal(10, 2)->notNull(),
            'credit' => $this->decimal(10, 2)->notNull(),
            'cost_center_id' => $this->bigInteger(),
            'status' => $this->boolean()->notNull()->defaultValue('1'),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'deleted_at' => $this->timestamp(),
        ]);

        $this->addForeignKey('foreign_key01', '{{%accounting_seats_details}}', 'accounting_seat_id', '{{%accounting_seats}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('foreign_key02', '{{%accounting_seats_details}}', 'chart_account_id', '{{%chart_accounts}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('foreign_key03', '{{%accounting_seats_details}}', 'cost_center_id', '{{%cost_center}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%accounting_seats_details}}');
    }
}
