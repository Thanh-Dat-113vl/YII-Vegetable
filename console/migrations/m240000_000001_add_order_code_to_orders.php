<?php

use yii\db\Migration;

/**
 * Class m240000_000001_add_order_code_to_orders
 */
class m240000_000001_add_order_code_to_orders extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%orders}}', 'order_code', $this->string(50)->notNull()->unique()->after('id'));
        $this->createIndex('idx-orders-order_code', '{{%orders}}', 'order_code', true);
    }

    public function safeDown()
    {
        $this->dropIndex('idx-orders-order_code', '{{%orders}}');
        $this->dropColumn('{{%orders}}', 'order_code');
    }
}
