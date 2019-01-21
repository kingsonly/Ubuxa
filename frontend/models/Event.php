<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%event}}".
 *
 * @property int $id
 * @property string $title
 * @property int $user_id
 * @property string $start_date
 * @property string $end_date
 * @property string $event_time
 * @property string $last_updated
 * @property int $deleted
 * @property int $cid
 *
 * @property Calendar[] $calendars
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%event}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'user_id', 'cid'], 'required'],
            [['user_id', 'deleted', 'cid'], 'integer'],
            [['start_date', 'end_date', 'event_time', 'last_updated'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'user_id' => 'User ID',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'event_time' => 'Event Time',
            'last_updated' => 'Last Updated',
            'deleted' => 'Deleted',
            'cid' => 'Cid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendars()
    {
        return $this->hasMany(Calendar::className(), ['event_id' => 'id']);
    }
}
