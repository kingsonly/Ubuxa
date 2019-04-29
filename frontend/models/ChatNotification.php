<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tm_chat_notification".
 *
 * @property int $id
 * @property int $sender_id
 * @property int $receivers_id
 * @property string $time_sent
 * @property string $last_updated
 */
class ChatNotification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tm_chat_notification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sender_id', 'receivers_id'], 'required'],
            [['sender_id', 'receivers_id'], 'integer'],
            [['time_sent', 'last_updated'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender_id' => 'Sender ID',
            'receivers_id' => 'Receivers ID',
            'time_sent' => 'Time Sent',
            'last_updated' => 'Last Updated',
        ];
    }
	
	public function getSender()
    {
        return $this->hasOne(UserDb::className(), ['id' => 'sender_id']);
    }
	
	public function getReceivers()
    {
        return $this->hasOne(UserDb::className(), ['id' => 'receivers_id']);
    }
	
	public function getFolder()
    {
        return $this->hasOne(Folder::className(), ['id' => 'folder_id']);
    }
}
