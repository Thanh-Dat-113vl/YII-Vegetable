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
    public const STATUS_REVIEW = '0'; //chờ duyệt;
    public const STATUS_APPROVED = '1'; //Xác nhận;

    public const STATUS_DELETED = '5'; //khóa

    public static function tableName()
    {
        return 'review';
    }

    public function rules()
    {
        // return [
        //     [['rating', 'comment', 'review_name', 'review_phone'], 'required'],
        //     [['rating'], 'integer'],
        //     [['comment'], 'string'],
        //     [['review_name'], 'string', 'max' => 255],
        //     [['review_phone'], 'string', 'max' => 20],
        //     [['status'], 'default', 'value' => 0], // mặc định là chờ duyệt
        // ];
    }

    public function actionCreate($product_id)
    {
        $model = new Review();
        $model->product_id = $product_id;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->created_at = date('Y-m-d H:i:s');
            $model->save(false);

            Yii::$app->session->setFlash('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
            return $this->redirect(['product/view', 'id' => $product_id]);
        }

        Yii::$app->session->setFlash('error', 'Gửi đánh giá thất bại!');
        return $this->redirect(['product/view', 'id' => $product_id]);
    }


    public function beforeSave($insert)
    {
        $this->rating = intval($this->rating);
        $this->user_id = Yii::$app->user->id;
        $this->review_name = Yii::$app->user->identity->username;
        $this->phone = Yii::$app->user->identity->phone;
        $this->comment = trim($this->comment);


        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->status = self::STATUS_REVIEW; // mặc định là chờ duyệt
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
