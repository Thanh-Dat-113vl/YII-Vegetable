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
 * @property string $order_code
 *
 * @property User $user
 * @property OrderItem[] $items
 */
class Orders extends ActiveRecord
{
    // trạng thái đơn hàng
    public const STATUS_PENDING = 'pending';   // xác nhận
    public const STATUS_CONFIRMED = 'comfirmed';
    public const STATUS_SHIPPING = 'shipping';  // giao hàng
    public const STATUS_COMPLETED = 'completed';   // nhận hàng / hoàn tất
    public const STATUS_CANCELED = 'canceled'; // hủy đơn hàng

    public static function tableName()
    {
        return 'orders';
    }

    public function rules()
    {
        return [
            [['user_id', 'order_code', 'status', 'payment_method'], 'required'],
            [['user_id'], 'integer'],
            [['shipping_address'], 'string', 'max' => 255],
            [['status', 'payment_method', 'order_code'], 'string', 'max' => 50],
            [['created_at', 'updated_at'], 'safe'],
            [['order_code'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'STT',
            'user_id' => 'Customer',
            'totalPrice' => 'Total Price',
            'status' => 'Status',
            'payment_method' => 'Payment Method',
            'shipping_address' => 'Address shipping',
            'shipping_fee' => 'Shipping Fee',
            'created_at' => 'Create date',
            'updated_at' => 'Update date',
            'order_code' => 'Order Code',
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
                // mặc định trạng thái khi tạo là pending (xác nhận)
                if ($this->status === null) {
                    $this->status = self::STATUS_PENDING;
                }
                if (empty($this->order_code)) {
                    $this->order_code = self::generateOrderCode();
                }
            }
            $this->updated_at = date('Y-m-d H:i:s');
            return true;
        }
        return false;
    }

    /**
     * Generate order code like ORD202511010001
     * Uses count of today's orders to produce 4-digit sequence.
     */
    public static function generateOrderCode(): string
    {
        $prefix = 'ORD' . date('Ymd');
        // count today's orders
        $count = (int) self::find()->where(['like', 'order_code', $prefix, false])->count();
        $seq = $count + 1;
        return $prefix . str_pad((string)$seq, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Trả label trạng thái
     */
    public function getStatusLabel(): string
    {
        switch ((int)$this->status) {
            case self::STATUS_PENDING:
                return 'chờ xác nhận';
            case self::STATUS_SHIPPING:
                return 'Đang giao';
            case self::STATUS_COMPLETED:
                return 'Đã nhận';
            case self::STATUS_CANCELED:
                return 'Đã hủy';
            default:
                return 'Chờ xác nhận';
        }
    }
}
