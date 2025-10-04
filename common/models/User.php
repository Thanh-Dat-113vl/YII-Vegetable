<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property integer $role

 */
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    const ROLE_ADMIN = 0;
    const ROLE_EMLOYEE = 1;
    const ROLE_CUSTOMER = 2;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => function () {
                    return date('Y-m-d H:i:s');
                }, // format datetime
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password_hash', 'auth_key', 'role', 'status', 'phone'], 'required'],
            [['username', 'email', 'password_hash', 'auth_key', 'verification_token'], 'string', 'max' => 255],
            ['email', 'email'],
            ['phone', 'string', 'max' => 10],
            [['phone'], 'unique', 'targetAttribute' => 'phone', 'message' => 'Số điện thoại đã tồn tại.'],
            ['phone', 'match', 'pattern' => '/^0\d{9}$/', 'message' => 'Số điện thoại phải có 10 số và bắt đầu bằng 0'],

            //     'password',
            //     'match',
            //     'pattern' => '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/',
            //     'message' => 'Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ, số và ký tự đặc biệt.'
            // ],
            [['role', 'status'], 'integer'],
            ['role', 'default', 'value' => self::ROLE_CUSTOMER],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],


            [['created_at', 'updated_at'], 'safe'],

            [['username'], 'unique', 'targetAttribute' => 'username', 'message' => 'Tên đăng nhập đã tồn tại.'],
            [['email'], 'unique', 'targetAttribute' => 'email', 'message' => 'Email đã tồn tại.'],
            // [['password_reset_token'], 'unique', 'targetAttribute' => 'password_reset_token'],


        ];
    }
    public function actionIndex()
    {
        $query = \common\models\User::find();

        $search = Yii::$app->request->get('username');
        if (!empty($search)) {
            $query->andWhere(['like', 'username', $search]);
        }

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'search' => $search,
        ]);
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->phone = $this->phone;

            if ($this->isNewRecord) {
                $this->role = self::ROLE_CUSTOMER;  // default

                $this->status = self::STATUS_ACTIVE; // default


                $this->auth_key = Yii::$app->security->generateRandomString();
                $this->created_at = date('Y-m-d H:i:s');
                $this->updated_at = date('Y-m-d H:i:s');
            }
            return true;
        }
        return false;
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    // public static function findByUsername($username)
    // {
    //     // return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    //     return static::find()
    //         ->where(['username' => $username])
    //         ->orWhere(['email' => $username])
    //         ->all();
    // }
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);

        // foreach (self::$usernames as $user) {
        //     if (strcasecmp($user['username'], $username) === 0 || strcasecmp($user['email'], $username) === 0) {
        //         return new static($user);
        //     }
        // }
    }


    /**
     * Finds user by password reset token 
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_ACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }


    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */

    public  $password;

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    public function getOrders()
    {
        return $this->hasMany(Orders::class, ['user_id' => 'id']);
    }
}
