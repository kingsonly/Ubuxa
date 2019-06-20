<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_device_push_token}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $push_token
 * @property int $device
 *
 * @property User $user
 */
class UserDevicePushToken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_device_push_token}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'push_token'], 'required'],
            [['user_id', 'device'], 'integer'],
            [['push_token'], 'string', 'max' => 255],
            [['push_token'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'push_token' => Yii::t('app', 'Push Token'),
            'device' => Yii::t('app', 'Device'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
