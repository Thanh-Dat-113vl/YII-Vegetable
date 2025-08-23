<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%banner}}`.
 */
class m250823_040331_create_banner_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%banner}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'image' => $this->string()->notNull(), // lưu đường dẫn ảnh
            'link' => $this->string()->null(),     // link khi click
            'status' => $this->boolean()->defaultValue(1), // 1 = hiển thị, 0 = ẩn
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%banner}}');
    }
}
