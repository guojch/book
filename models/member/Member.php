<?php

namespace app\models\member;

use Yii;

/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property string $nickname
 * @property string $mobile
 * @property integer $sex
 * @property string $avatar
 * @property string $salt
 * @property string $reg_ip
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class Member extends \yii\db\ActiveRecord
{
	public function setSalt( $length = 16 ){
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
		$salt = '';
		for ( $i = 0; $i < $length; $i++ ){
			$salt .= $chars[ mt_rand(0, strlen($chars) - 1) ];
		}
		$this->salt = $salt;
	}
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex', 'status'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['nickname', 'reg_ip'], 'string', 'max' => 100],
            [['mobile'], 'string', 'max' => 11],
            [['avatar'], 'string', 'max' => 200],
            [['salt'], 'string', 'max' => 32],
            [['mobile'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nickname' => 'Nickname',
            'mobile' => 'Mobile',
            'sex' => 'Sex',
            'avatar' => 'Avatar',
            'salt' => 'Salt',
            'reg_ip' => 'Reg Ip',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
