<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\debug\models\search\User as SearchUser;
use yii\rbac\Role;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $verifyCode;
    public $role = '2'; // Mặc định là customer
    public $status = '10'; // Mặc định là active
    public $phone;



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email',  'role', 'status', 'phone'], 'required'],

            ['phone', 'string', 'max' => 10],
            ['phone', 'match', 'pattern' => '/^0[0-9]{9}$/', 'message' => 'Số điện thoại không hợp lệ.'],

            [['username', 'email'], 'trim'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],


            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required', 'message' => 'Vui lòng nhập mật khẩu.'],
            ['password', 'string', 'min' => 3, 'tooShort' => 'Mật khẩu phải có ít nhất 3 ký tự.'],
            // ['password', 'match', 'pattern' => '/[A-Z]/', 'message' => 'Mật khẩu phải chứa ít nhất một chữ cái viết hoa.'],
            // ['password', 'match', 'pattern' => '/[a-z]/', 'message' => 'Mật khẩu phải chứa ít nhất một chữ cái viết thường.'],
            // ['password', 'match', 'pattern' => '/\d/', 'message' => 'Mật khẩu phải chứa ít nhất một chữ số.'],
            // ['password', 'match', 'pattern' => '/[\W_]/', 'message' => 'Mật khẩu phải chứa ít nhất một ký tự đặc biệt.'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;

        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->phone = $this->phone;

        $user->role = User::ROLE_CUSTOMER;
        $user->status = User::STATUS_ACTIVE;
        // $user->generateEmailVerificationToken();

        // return $user->save() || $this->sendEmail($user);
        // if ($user->save()) {
        //     return $this->sendEmail($user);
        // }



        if ($user->save()) {
            return $user;
        } else {
            \Yii::error($user->errors, __METHOD__); // log vào runtime/logs/app.log
            var_dump($user->errors); // in trực tiếp ra màn hình
            exit;
        }
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' admin'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
