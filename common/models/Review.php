<?php

namespace common\models;

use yii\db\ActiveRecord;

class Review extends ActiveRecord
{
    public static function tableName()
    {
        return 'review';
    }

    public function rules()
    {
        return [
            [['user_id', 'product_id', 'rating'], 'required'],
            ['rating', 'integer', 'min' => 1, 'max' => 5],
            ['comment', 'string'],
            [['created_at'], 'safe']
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
