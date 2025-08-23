<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int|null $user_id
 * @property float|null $total_price
 * @property string $status
 * @property string|null $payment_method
 * @property string|null $shipping_address
 * @property float|null $shipping_fee
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $user
 * @property OrderItem[] $items
 */
class Orders extends ActiveRecord
{
    public static function tableName()
    {
        return 'orders';
    }

    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['total_price', 'shipping_fee'], 'number'],
            [['shipping_address'], 'string'],
            [['status', 'payment_method'], 'string', 'max' => 50],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Mã đơn hàng',
            'user_id' => 'Khách hàng',
            'total_price' => 'Tổng tiền',
            'status' => 'Trạng thái',
            'payment_method' => 'Phương thức thanh toán',
            'shipping_address' => 'Địa chỉ giao hàng',
            'shipping_fee' => 'Phí vận chuyển',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
        ];
    }

    /** Quan hệ: đơn hàng thuộc về user */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /** Quan hệ: đơn hàng có nhiều item */
    public function getItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

    /** Tự động set ngày tạo/cập nhật */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = date('Y-m-d H:i:s');
            }
            $this->updated_at = date('Y-m-d H:i:s');
            return true;
        }
        return false;
    }
}
