<?php

namespace backend\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use common\models\User;
use yii\web\NotFoundHttpException;
use yii\helpers\Inflector;


class UsersController extends Controller
{
    public function actionIndex()
    {
        $search = Yii::$app->request->get('username');

        $query = User::find();
        if (!empty($search)) {
            $query->andWhere(['like', 'username', $search]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'search' => $search,
        ]);
    }



    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (empty($model->password)) {
                $model->addError('password', 'Vui lòng nhập mật khẩu.');
            } else {
                Yii::$app->session->setFlash('success', 'Thêm người dùng thành công!');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Cập nhật người dùng thành công!');
            return $this->redirect(['index']);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Xóa người dùng thành công!');
        return $this->redirect(['index']);
    }

    public function actionToggleStatus($id)
    {
        $model = $this->findModel($id);
        $model->status = $model->status ? 0 : 1;
        if ($model->save(false, ['status'])) {
            Yii::$app->session->setFlash('success', 'Chuyển trạng thái thành công!');
        } else {
            Yii::$app->session->setFlash('error', 'Chuyển trạng thái thất bại!');
        }
        return $this->redirect(['index']);
    }


    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }


        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionResetPassword($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException("User not found");
        }

        // Sinh mật khẩu mới (8 ký tự ngẫu nhiên)
        $newPassword = Yii::$app->security->generateRandomString(8);

        // Hash lại
        $user->password_hash = Yii::$app->security->generatePasswordHash($newPassword);

        if ($user->save(false)) {
            // Gửi email cho user
            Yii::$app->mailer->compose()
                ->setTo($user->email)
                ->setFrom([Yii::$app->params['adminEmail'] => 'Admin'])
                ->setSubject('Mật khẩu mới của bạn')
                ->setHtmlBody("
                <p>Xin chào <b>{$user->username}</b>,</p>
                <p>Mật khẩu mới của bạn là: <b>{$newPassword}</b></p>
                <p>Vui lòng đăng nhập và đổi lại mật khẩu.</p>
            ")
                ->send();

            Yii::$app->session->setFlash('success', 'Mật khẩu đã được reset và gửi tới email người dùng.');
        } else {
            Yii::$app->session->setFlash('error', 'Không thể reset mật khẩu.');
        }

        return $this->redirect(['index']);
    }
}
