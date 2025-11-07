<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property int $status
 * @property int|null $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Product[] $products
 * @property User $creator
 */
class Category extends ActiveRecord
{
    public static function tableName()
    {
        return 'category';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'slug'], 'string', 'max' => 255],
            ['name', 'unique', 'targetAttribute' => 'name', 'message' => 'Tên danh mục đã tồn tại.'],
            [['slug'], 'unique', 'targetAttribute' => 'slug', 'message' => 'Slug đã tồn tại.'],
            [['status', 'created_by'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name Category',
            'slug' => 'Slug',
            'status' => 'Status',
            'created_by' => 'User Created',
            'created_at' => 'Date Created',
            'updated_at' => 'Date Updated',
        ];
    }

    /**
     * Quan hệ: 1 category có nhiều sản phẩm
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['category_id' => 'id']);
    }

    /**
     * Quan hệ: Người tạo danh mục
     */
    public function getCreator()
    {
        return $this->hasOne(\common\models\User::class, ['id' => 'created_by']);
    }

    /**
     * Tự sinh slug và gán created_by khi save
     */
    public function beforeSave($insert)
    {
        // $this->image = null;
        if (parent::beforeSave($insert)) {
            if (empty($this->slug)) {
                $name = (string) ($this->name ?? '');
                $this->slug = strtolower(str_replace(' ', '-', $name));
            }
            if ($this->isNewRecord) {
                $this->created_at = date('Y-m-d H:i:s');
                $this->created_by = Yii::$app->user->id ?? null;
            }
            $this->updated_at = date('Y-m-d H:i:s');
            return true;
        }
        return false;
    }
}
