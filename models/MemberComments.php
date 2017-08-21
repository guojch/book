<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "member_comments".
 *
 * @property integer $id
 * @property integer $member_id
 * @property integer $book_id
 * @property integer $order_id
 * @property integer $score
 * @property string $content
 * @property string $created_time
 */
class MemberComments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member_comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'book_id', 'order_id', 'score'], 'integer'],
            [['created_time'], 'safe'],
            [['content'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => 'Member ID',
            'book_id' => 'Book ID',
            'order_id' => 'Order ID',
            'score' => 'Score',
            'content' => 'Content',
            'created_time' => 'Created Time',
        ];
    }
}
