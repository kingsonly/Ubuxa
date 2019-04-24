<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%activity}}".
 *
 * @property string $id
 * @property string $session_id assuming session in db - else you need activity group
 * @property string $activity_group use this when you cannot be sure that session id is consistent - saved in client cookies
 * @property int $user_id
 * @property int $object_id
 * @property string $action_id
 * @property int $in_progress
 *
 * @property Session $session
 * @property User $user
 */
class Activity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%activity}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'session_id', 'activity_group'], 'required'],
            [['user_id', 'object_id', 'in_progress'], 'integer'],
            [['id', 'action_id'], 'string', 'max' => 255],
            [['session_id', 'activity_group'], 'string', 'max' => 64],
            [['session_id'], 'unique'],
            [['activity_group'], 'unique'],
            [['id'], 'unique'],
            [['session_id'], 'exist', 'skipOnError' => true, 'targetClass' => Session::className(), 'targetAttribute' => ['session_id' => 'id']],
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
            'session_id' => 'assuming session in db - else you need activity group',
            'activity_group' => 'use this when you cannot be sure that session id is consistent - saved in client cookies',
            'user_id' => 'User ID',
            'object_id' => 'Object ID',
            'action_id' => 'Action ID',
            'in_progress' => 'In Progress',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSession()
    {
        return $this->hasOne(Session::className(), ['id' => 'session_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserDb::className(), ['id' => 'user_id']);
    }
}
