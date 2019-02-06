<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%google_calendar_id}}".
 *
 * @property int $id
 * @property string $calendar_id
 * @property int $user_id
 */
class GoogleCalendarId extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%google_calendar_id}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['calendar_id', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['calendar_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'calendar_id' => 'Calendar ID',
            'user_id' => 'User ID',
        ];
    }
}
