<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;



class Product extends ActiveRecord
{
    /** @var UploadedFile */
    public $imageFile;

    public static function tableName()
    {
        return 'product';
    }

    public function rules()
    {
        return [
            [['name', 'price', 'category_id', 'stock'], 'required'],
            [['description', 'unit'], 'string'],
            [['price'], 'number'],
            [['stock', 'category_id', 'created_by', 'updated_by', 'discount'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'slug', 'image'], 'string', 'max' => 255],

            // [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],

        ];
    }

    // public function attributeLabels()
    // {
    //     return [
    //         'id' => 'ID',
    //         'name' => 'Tên sản phẩm',
    //         'slug' => 'Slug',
    //         'description' => 'Mô tả',
    //         'price' => 'Giá',
    //         'stock' => 'Tồn kho',
    //         'category_id' => 'Danh mục',
    //         'image' => 'Hình ảnh',
    //         'created_at' => 'Ngày tạo',
    //         'updated_at' => 'Ngày cập nhật',
    //     ];
    // }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Tạo slug từ tên sản phẩm
            $this->name = trim($this->name);
            $this->slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $this->name));
            $this->price = floatval($this->price);
            $this->stock = intval($this->stock);
            $this->description = trim($this->description);
            $this->discount = $this->discount ? intval($this->discount) : 0;

            if ($this->isNewRecord) {
                $this->created_by = Yii::$app->user->id;
                $this->created_at = date('Y-m-d H:i:s');
            } else {
                $this->updated_by = Yii::$app->user->id;
                $this->updated_at = date('Y-m-d H:i:s');
            }


            return true;
        }
        return false;
    }
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),  // DB tự động sinh giờ
            ],
        ];
    }

    public function getFinalPrice()
    {
        if ($this->discount > 0) {
            return $this->price - ($this->price * $this->discount / 100);
        }
        return $this->Finalprice;
    }


    public function upload()
    {
        if ($this->validate()) {
            if ($this->imageFile) {
                $uploadPath = Yii::getAlias('@backend/web/uploads');

                // Tạo thư mục nếu chưa có
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $fileName = 'product_' . time() . '.' . $this->imageFile->extension;
                $fullPath = $uploadPath . DIRECTORY_SEPARATOR . $fileName;

                if ($this->imageFile->saveAs($fullPath)) {
                    $this->image = $fileName;
                    return true;
                }
            }
        }
        return false;

        // if ($this->validate()) {
        //     if ($this->imageFile) {
        //         $uploadPath = Yii::getAlias('@backend/web/uploads');
        //         if (!is_dir($uploadPath)) {
        //             mkdir($uploadPath, 0777, true);
        //         }

        //         $fileName = 'product_' . time() . '.' . $this->imageFile->extension;
        //         $fullPath = $uploadPath . DIRECTORY_SEPARATOR . $fileName;

        //         if ($this->imageFile->saveAs($fullPath)) {
        //             $this->image = $fileName;
        //             return true;
        //         } else {
        //             throw new \Exception("Không lưu được file: $fullPath");
        //         }
        //     } else {
        //         throw new \Exception("Không có file upload");
        //     }
        // } else {
        //     var_dump($this->getErrors());
        //     exit;
        // }
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['product_id' => 'id']);
    }
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['product_id' => 'id']);
    }
    public function getCreator()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }
}
