<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $uid
 * @property string $nickname
 * @property string $mobile
 * @property string $email
 * @property integer $sex
 * @property string $avatar
 * @property string $login_name
 * @property string $login_pwd
 * @property string $login_salt
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class User extends \yii\db\ActiveRecord
{
	public function setPassword( $password ) {

		$this->login_pwd = $this->getSaltPassword($password);
	}


	public function setSalt( $length = 16 ){
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
		$salt = '';
		for ( $i = 0; $i < $length; $i++ ){
			$salt .= $chars[ mt_rand(0, strlen($chars) - 1) ];
		}
		$this->login_salt = $salt;
	}

	public function getSaltPassword($password) {
		return md5( $password.md5( $this->login_salt ) );
	}


	public function verifyPassword($password) {
		return $this->login_pwd === $this->getSaltPassword($password);
	}
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile', 'email', 'avatar'], 'required'],
            [['sex', 'status'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['nickname', 'email'], 'string', 'max' => 100],
            [['mobile', 'login_name'], 'string', 'max' => 20],
            [['avatar'], 'string', 'max' => 64],
            [['login_pwd', 'login_salt'], 'string', 'max' => 32],
            [['login_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'nickname' => 'Nickname',
            'mobile' => 'Mobile',
            'email' => 'Email',
            'sex' => 'Sex',
            'avatar' => 'Avatar',
            'login_name' => 'Login Name',
            'login_pwd' => 'Login Pwd',
            'login_salt' => 'Login Salt',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
