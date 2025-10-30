<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property int $rating
 * @property string|null $comment
 * @property string $created_at
 *
 * @property User $user
 * @property Product $product
 */
class Review extends ActiveRecord
{
    public static function tableName()
    {
        return 'review';
    }

    public function rules()
    {
        return [
            [['product_id', 'user_id', 'rating', 'review_name', 'review_phone'], 'required'],
            [['product_id', 'user_id', 'rating'], 'integer'],
            ['rating', 'integer', 'min' => 1, 'max' => 5],

            ['comment', 'string', 'max' => 1000],
            ['created_at', 'safe'],
        ];
    }

    public function beforeSave($insert)
    {
        $this->rating = intval($this->rating);
        $this->user_id = Yii::$app->user->id;
        $this->created_at = Yii::$app->user->id;
        $this->review_name = trim($this->review_name);


        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->created_at = date('Y-m-d H:i:s');
            }
            return true;
        }
        return false;
    }


    public function attributeLabels()
    {
        return [
            'rating' => 'Đánh giá',
            'comment' => 'Bình luận',
            'created_at' => 'Ngày',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
