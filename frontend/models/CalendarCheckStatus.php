<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%calendar_check_status}}".
 *
 * @property int $id
 * @property int $status
 * @property int $user_id
 */
class CalendarCheckStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%calendar_check_status}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'user_id'], 'integer'],
            [['user_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'user_id' => 'User ID',
        ];
    }
}
