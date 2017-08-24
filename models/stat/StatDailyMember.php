<?php

namespace app\models\stat;

use Yii;

/**
 * This is the model class for table "stat_daily_member".
 *
 * @property integer $id
 * @property string $date
 * @property integer $member_id
 * @property integer $total_shared_count
 * @property string $total_pay_money
 * @property string $updated_time
 * @property string $created_time
 */
class StatDailyMember extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stat_daily_member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'required'],
            [['date', 'updated_time', 'created_time'], 'safe'],
            [['member_id', 'total_shared_count'], 'integer'],
            [['total_pay_money'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'member_id' => 'Member ID',
            'total_shared_count' => 'Total Shared Count',
            'total_pay_money' => 'Total Pay Money',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
