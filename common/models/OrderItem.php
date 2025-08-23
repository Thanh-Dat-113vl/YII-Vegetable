<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order_item".
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int $quantity
 * @property float $price
 *
 * @property Orders $order
 * @property Product $product
 */
class OrderItem extends ActiveRecord
{
    public static function tableName()
    {
        return 'order_item';
    }

    public function rules()
    {
        return [
            [['order_id', 'product_id', 'quantity', 'price'], 'required'],
            [['order_id', 'product_id', 'quantity'], 'integer'],
            [['price'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Mã đơn hàng',
            'product_id' => 'Sản phẩm',
            'quantity' => 'Số lượng',
            'price' => 'Giá',
        ];
    }

    /** Quan hệ: 1 OrderItem thuộc về 1 Order */
    public function getOrder()
    {
        return $this->hasOne(Orders::class, ['id' => 'order_id']);
    }

    /** Quan hệ: 1 OrderItem thuộc về 1 Product */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
    public function getItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }
}
