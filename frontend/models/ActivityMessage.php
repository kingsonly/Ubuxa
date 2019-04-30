<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%activity_message}}".
 *
 * @property string $id
 * @property string $activity_id
 * @property string $message
 * @property int $user_id
 * @property int $cid
 *
 * @property Activity $activity
 * @property User $user
 */
class ActivityMessage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%activity_message}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['user_id', 'cid'], 'integer'],
            [['id', 'activity_id'], 'string', 'max' => 64],
            [['message'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['activity_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity_id' => 'Activity ID',
            'message' => 'Message',
            'user_id' => 'User ID',
            'cid' => 'Cid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(Activity::className(), ['id' => 'activity_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
