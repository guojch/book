<?php

namespace app\models\stat;

use Yii;

/**
 * This is the model class for table "stat_daily_site".
 *
 * @property integer $id
 * @property string $date
 * @property string $total_pay_money
 * @property integer $total_member_count
 * @property integer $total_new_member_count
 * @property integer $total_order_count
 * @property integer $total_shared_count
 * @property string $updated_time
 * @property string $created_time
 */
class StatDailySite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stat_daily_site';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'required'],
            [['date', 'updated_time', 'created_time'], 'safe'],
            [['total_pay_money'], 'number'],
            [['total_member_count', 'total_new_member_count', 'total_order_count', 'total_shared_count'], 'integer'],
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
            'total_pay_money' => 'Total Pay Money',
            'total_member_count' => 'Total Member Count',
            'total_new_member_count' => 'Total New Member Count',
            'total_order_count' => 'Total Order Count',
            'total_shared_count' => 'Total Shared Count',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
