<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\BoffinsArRootModel;
use boffins_vendor\classes\models\{TenantSpecific, TrackDeleteUpdateInterface};


/**
 * This is the model class for table "{{%reminder}}".
 *
 * @property int $id
 * @property string $reminder_time
 * @property string $notes
 * @property string $last_updated
 * @property int $deleted
 * @property int $cid
 *
 * @property TaskReminder[] $taskReminders
 */
class Reminder extends BoffinsArRootModel implements TenantSpecific, TrackDeleteUpdateInterface
{
    /**
     * {@inheritdoc}
     */
    const REMINDER_NOT_DELETED = 0 ; //Reminder status value when it is not deleted
    const REMINDER_DELETED = 1 ; //Reminder status value when it is deleted
    const REMINDER_SENT = 2; //Reminder status when it is sent
    
    public static function tableName()
    {
        return '{{%reminder}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reminder_time', 'last_updated'], 'required'],
            [['reminder_time', 'last_updated','deleted', 'notes'], 'safe'],
            [['deleted', 'cid'], 'integer'],
            [['notes'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reminder_time' => 'Reminder Time',
            'notes' => 'Notes',
            'last_updated' => 'Last Updated',
            'deleted' => 'Deleted',
            'cid' => 'Cid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskReminders()
    {
        return $this->hasMany(TaskReminder::className(), ['reminder_id' => 'id']);
    }

    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['id' => 'task_id'])
            ->via('taskReminders');
    }

    public function checkForReminders($presentTime)
    {
        $reminderAlert = Reminder::find()->andWhere(['<=', 'reminder_time', $presentTime])
            ->andWhere(['deleted'=>self::REMINDER_NOT_DELETED]) 
            ->all();
        return $reminderAlert;
    }

    public function getCalendarreminder()
    {
        return $this->hasOne(CalendarReminder::className(), ['reminder_id' => 'id']);
    }
}
