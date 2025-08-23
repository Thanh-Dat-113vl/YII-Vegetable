<?php

namespace common\models;

use yii\db\ActiveRecord;

class Banner extends ActiveRecord
{
    public static function tableName()
    {
        return 'banner';
    }

    public function rules()
    {
        return [
            [['title', 'image'], 'required'],
            [['status'], 'boolean'],
            [['title', 'image', 'link'], 'string', 'max' => 255],
        ];
    }
}
