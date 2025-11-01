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
    public const STATUS_PENDING = 1;   // xác nhận
    public const STATUS_SHIPPING = 2;  // giao hàng
    public const STATUS_COMPLETED = 3; // nhận hàng / hoàn tất

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
            [['order_code'], 'string', 'max' => 50],
            [['order_code'], 'unique'],
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
            'order_code' => 'Mã đơn hàng',
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
                return 'Xác nhận';
            case self::STATUS_SHIPPING:
                return 'Đang giao';
            case self::STATUS_COMPLETED:
                return 'Đã nhận';
            default:
                return 'Không rõ';
        }
    }
}
