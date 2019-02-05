<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%calendar}}".
 *
 * @property int $id
 * @property int $last_id
 * @property int $type
 * @property int $user_id
 * @property int $deleted
 * @property string $last_updated
 * @property int $cid
 *
 * @property Event $last
 * @property Task $last0
 */
class Calendar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const TASK_NOT_DELETED = 0; //TASK THAT HAVE NOT BEEN DELETED STATUS
    const REMOVE_AFTER_DROP_STATUS = 1; //UPDATE REMOVE AFTER DROP STATUS WITH 1
    const TASK_GROUP_CHECKED = 1; //value of task group when checked
    const TASK_GROUP_NOT_CHECKED = 0; //value of task group when not checked
    const GOOGLE_CALENDAR = 1; //value of status when calendar type is google calendar
    const UBUXA_CALENDAR = 0; //value of status when calendar type is ubuxa calendar

    public static function tableName()
    {
        return '{{%calendar}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['last_id', 'type'], 'required'],
            [['last_id','user_id', 'deleted', 'cid'], 'integer'],
            [['last_updated'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'last_id' => 'Last ID',
            'type' => 'Type',
            'user_id' => 'User ID',
            'deleted' => 'Deleted',
            'last_updated' => 'Last Updated',
            'cid' => 'Cid',
        ];
    }

    
}
