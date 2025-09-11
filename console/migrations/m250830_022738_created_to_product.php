<?php

use yii\db\Migration;

class m240101_123456_add_created_by_to_product extends Migration
{
    public function safeUp()
    {
        $this->addColumn('product', 'created_by', $this->integer()->after('id'));
        $this->addForeignKey(
            'fk_product_user',
            'product',
            'created_by',
            'user',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_product_user', 'product');
        $this->dropColumn('product', 'created_by');
    }
}
