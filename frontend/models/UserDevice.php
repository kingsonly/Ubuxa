<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%user_device}}".
 *
 * @property integer $user_id
 * @property integer $device_id
 */
class UserDevice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_device}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'device_id'], 'required'],
            [['user_id', 'device_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' =>  Yii::t('UserDevice', 'User ID'),
            'device_id' =>  Yii::t('UserDevice', 'Device ID'),
        ];
    }
}
