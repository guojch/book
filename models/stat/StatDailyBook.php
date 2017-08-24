<?php

namespace app\models\stat;

use Yii;

/**
 * This is the model class for table "stat_daily_book".
 *
 * @property integer $id
 * @property string $date
 * @property integer $book_id
 * @property integer $total_count
 * @property string $total_pay_money
 * @property string $updated_time
 * @property string $created_time
 */
class StatDailyBook extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stat_daily_book';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'required'],
            [['date', 'updated_time', 'created_time'], 'safe'],
            [['book_id', 'total_count'], 'integer'],
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
            'book_id' => 'Book ID',
            'total_count' => 'Total Count',
            'total_pay_money' => 'Total Pay Money',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
