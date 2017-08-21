<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property string $nickname
 * @property string $phone
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
            [['phone'], 'string', 'max' => 11],
            [['avatar'], 'string', 'max' => 200],
            [['salt'], 'string', 'max' => 32],
            [['phone'], 'unique'],
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
            'phone' => 'Phone',
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
