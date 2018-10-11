<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%device_access_token}}".
 *
 * @property string $token
 * @property string $valid_to
 * @property string $device_string
 */
class DeviceAccessToken extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%device_access_token}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['token', 'valid_to', 'device_string'], 'required'],
            [['valid_to'], 'safe'],
            [['token'], 'string', 'max' => 10],
            [['device_string'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'token' =>   Yii::t('DeviceAccessToken', 'Token'),
            'valid_to' =>   Yii::t('DeviceAccessToken', 'Valid Until'),
            'device_string' =>   Yii::t('DeviceAccessToken', 'Device String'),
        ];
    }
}
