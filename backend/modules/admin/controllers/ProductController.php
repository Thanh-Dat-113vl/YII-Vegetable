<?php

namespace backend\modules\admin\controllers;

use yii\web\Controller;
use yii\data\ActiveDataProvider;
use common\models\Product;
use common\models\Category;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\db\Expression;
use Yii;



/**
 * Default controller for the `admin` module
 */
class ProductController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'image');

            $model->created_by = Yii::$app->user->id; // Gán user hiện tại vào trường created_by
            // $model->created_at = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');;
            // $model->updated_at = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');;

            if ($model->upload() && $model->save(false)) {
                Yii::$app->session->setFlash('success', 'Tạo sản phẩm thành công!');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'name');
        return $this->render('create', [
            'model' => $model,
            'categories' => $categories,
        ]);
    }
    public function actionToggleStatus($id)
    {
        $model = Product::findOne($id);
        if ($model) {
            $model->status = $model->status ? 0 : 1;
            $model->save(false);
        }
        return $this->redirect(['index']);
    }

    public function actionUpdate($id)
    {
        $model = Product::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Sản phẩm không tồn tại.');
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_by = Yii::$app->user->id;
            $model->updated_at = date('Y-m-d H:i:s');

            $oldImage = $model->getOldAttribute('image'); // giữ lại ảnh cũ
            $model->imageFile = UploadedFile::getInstance($model, 'image');

            if ($model->imageFile) {
                $newHash = md5_file($model->imageFile->tempName);
                $oldPath = Yii::getAlias('@backend/web/uploads/') . $oldImage;

                if (file_exists($oldPath)) {
                    $oldHash = md5_file($oldPath);
                } else {
                    $oldHash = null;
                }

                if ($newHash === $oldHash) {
                    // Ảnh mới giống hệt ảnh cũ → không lưu file mới
                    $model->image = $oldImage;
                } else {
                    // Ảnh khác → tạo file mới
                    $fileName = 'product_' . time() . '.' . $model->imageFile->extension;
                    $uploadPath = Yii::getAlias('@backend/web/uploads/') . $fileName;
                    if ($model->imageFile->saveAs($uploadPath)) {
                        $model->image = $fileName;
                        // Xóa ảnh cũ nếu cần
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }
                }
            } else {
                $model->image = $oldImage;
            }


            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Cập nhật sản phẩm thành công!');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Lỗi khi lưu dữ liệu: ' . json_encode($model->getErrors()));
            }
        }


        return $this->render('update', [
            'model' => $model,
            'categories' => ArrayHelper::map(Category::find()->all(), 'id', 'name'),
        ]);
    }

    public function actionView($id)
    {
        $model = Product::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Sản phẩm không tồn tại.');
        }

        return $this->render('view', ['model' => $model]);
    }
    public function actionDelete($id)
    {
        $model = Product::findOne($id);
        if ($model) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Xóa sản phẩm thành công!');
        } else {
            Yii::$app->session->setFlash('error', 'Sản phẩm không tồn tại.');
        }
        return $this->redirect(['index']);
    }

    public function getPriceAfterDiscount($price, $discount)
    {
        return $price - ($price * $discount / 100);
    }
}
