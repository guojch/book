<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "app_access_log".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $referer_url
 * @property string $target_url
 * @property string $query_params
 * @property string $ua
 * @property string $ip
 * @property string $note
 * @property string $created_time
 */
class AppAccessLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_access_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['query_params'], 'required'],
            [['query_params'], 'string'],
            [['created_time'], 'safe'],
            [['referer_url', 'target_url', 'ua'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 32],
            [['note'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'referer_url' => 'Referer Url',
            'target_url' => 'Target Url',
            'query_params' => 'Query Params',
            'ua' => 'Ua',
            'ip' => 'Ip',
            'note' => 'Note',
            'created_time' => 'Created Time',
        ];
    }
}
