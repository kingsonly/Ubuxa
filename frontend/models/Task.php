<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\BoffinsArRootModel;
use boffins_vendor\classes\models\{TenantSpecific, TrackDeleteUpdateInterface, ClipableInterface, ClipperInterface};

/**
 * This is the model class for table "{{%task}}".
 *
 * @property int $id
 * @property string $title
 * @property string $details
 * @property int $owner
 * @property int $assigned_to
 * @property int $status_id
 * @property string $create_date
 * @property string $due_date
 * @property string $last_updated
 * @property int $deleted
 * @property int $cid
 *
 * @property ComponentTask[] $componentTasks
 * @property FolderTask[] $folderTasks
 * @property Folder[] $folders
 * @property User $assignedTo
 * @property User $owner0
 * @property TaskStatus $status
 * @property TaskReminder[] $taskReminders
 */
class Task extends BoffinsArRootModel implements TenantSpecific, TrackDeleteUpdateInterface, ClipableInterface, ClipperInterface 
{
    /***
     * accessible value linked to the database id of "completed" in status_type under task group.. 
     * needs to be refactored. If the DB id changes, what happens??? What about other phases dynamically set?
     */
    const TASK_COMPLETED = 24;
    /***
     * accessible value linked to the database id of "in_progress" in status_type under task group.. 
     * needs to be refactored. If the DB id changes, what happens??? What about other phases dynamically set?
     */
    const TASK_IN_PROGRESS = 22;
    /***
     * accessible value linked to the database id of "not started" in status_type under task group.. 
     * needs to be refactored. If the DB id changes, what happens??? What about other phases dynamically set?
     */
    const TASK_NOT_STARTED = 21;
    /**
     * {@inheritdoc}
     */
    const TASK_ASSIGNED_STATUS = 1;

    const TASK_NOT_ASSIGNED_STATUS = 0;
    public const DEFAULT_PARENT_ID = 0;
	public $fromWhere; // a public attribute only used by clipon behavior
    
    public static function tableName()
    {
        return '{{%task}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['owner','status_id', 'create_date'], 'required'],
            [['owner', 'status_id', 'deleted', 'cid'], 'integer'],
            [['create_date', 'due_date', 'last_updated','ownerId','title','fromWhere'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['details'], 'string', 'max' => 255],
            
            [['owner'], 'exist', 'skipOnError' => true, 'targetClass' => UserDb::className(), 'targetAttribute' => ['owner' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusType::className(), 'targetAttribute' => ['status_id' => 'id']],
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
            'details' => 'Details',
            'owner' => 'Owner',
            'status_id' => 'Status ID',
            'create_date' => 'Create Date',
            'due_date' => 'Due Date',
            'last_updated' => 'Last Updated',
            'deleted' => 'Deleted',
            'cid' => 'Cid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponentTasks()
    {
        return $this->hasMany(ComponentTask::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFolderTasks()
    {
        return $this->hasMany(FolderTask::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFolders()
    {
        return $this->hasMany(Folder::className(), ['id' => 'folder_id'])->viaTable('{{%folder_task}}', ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner0()
    {
        return $this->hasOne(UserDb::className(), ['id' => 'owner']);
    }

    public function getOwnerName()
    {
        return $this->owner0->username;
    }

    public function getOwnerFullName()
    {
        return $this->owner0->fullName;
    }

    public function getTaskLabels()
    {
        return $this->hasMany(TaskLabel::className(), ['task_id' => 'id']);
    }

    public function getLabels()
    {
        return $this->hasMany(Label::className(), ['id' => 'label_id'])->via('taskLabels');
    }

    public function getLabelNames()
    {
        $label = [];
        $data = $this->labels;
        foreach($data as $attr) {
            $label[] = $attr->name;
        }
        return implode('</span>' . PHP_EOL . '<span class="label-task">', $label);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(StatusType::className(), ['id' => 'status_id']);
    }


    public function getStatusTitle()
    {
        return $this->status->status_title;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskReminders()
    {
        return $this->hasMany(TaskReminder::className(), ['task_id' => 'id']);
    }

    public function getReminders()
    {
        return $this->hasMany(Reminder::className(), ['id' => 'reminder_id'])->via('taskReminders');
    }

    public function getReminderTime()
    {
        $time = [];
        $data = $this->reminders;
        foreach($data as $attr) {
            $time[] = $attr->reminder_time;
        }
        return implode(",", $time);
    }

    public function getReminderTimeTask()
    {
        $time = [];
        $data = $this->reminders;
        
        return $data;
    }

    public function closestReminder($reminders, $date)
    {
        foreach($reminders as $day){
            $interval[] = abs(strtotime($date) - strtotime($day));
        }

        asort($interval);
        $closest = key($interval);

        return $reminders[$closest];
    }

    public function getTaskAssignedUsers()
    {
        return $this->hasMany(TaskAssignedUser::className(), ['task_id' => 'id'])->andOnCondition(['status' => 1]);
    }

    public function getTaskAssignees()
    {
            return $this->hasMany(UserDb::className(), ['id' => 'user_id'])->via('taskAssignedUsers');
    }

    public function getPerson()
    {
        return $this->hasMany(Person::className(), ['id' => 'person_id'])->via('taskAssignees');
    }


    public function getPersonName()
    {   
        $names = [];
        $data = $this->person;
        foreach($data as $attr) {
            $names[] = $attr->first_name.' '.$attr->surname;
        }
        return implode(" ", $names);

        //return $this->person->first_name;
    }

    public function getTaskAssigneesUserId()
    {
        $userids = [];
        $data = $this->taskAssignees;
        foreach ($data as $attr) {
            $userids[] = $attr->id;
        }
        return $userids;
    }

    public function displayTask()
    {
        $task = $this->find()->orderBy(['id'=>SORT_ASC])->all();
        return $task;
    }

    public function getDashboardTask()
    {
        $task = $this->find()->orderBy(['id'=>SORT_DESC])->all();
        return $task;
    }

    public function formatInterval($interval) {
        $result = "";
        if ($interval->y) { $result .= $interval->format("%y years "); }
        if ($interval->m) { $result .= $interval->format("%m months "); }
        if ($interval->d) { $result .= $interval->format("%d day(s) "); }
        if ($interval->h) { $result .= $interval->format("%h hours "); }
        if ($interval->i) { $result .= $interval->format("%i minutes "); }
        if ($interval->s) { $result .= $interval->format("%s seconds "); }

        return $result;
    }

    public function getTimeCompletion()
    {
        $startTime = new \DateTime($this->in_progress_time);
        $endTime = new \DateTime($this->completion_time);

        
        $timeTaken = $startTime->diff($endTime);

        return $this->formatInterval($timeTaken);
    }

    public function getTaskGroup()
    {
        return $this->hasOne(TaskGroup::className(), ['task_group_id' => 'id']);
    }
    public function getTaskChild()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_child_id']);
    }
    public function getTaskColor()
    {
        return $this->hasOne(TaskColor::className(), ['task_group_id' => 'id']);
    }

    public function getTimeElapsedString($full = false) {
        $now = new \DateTime();
        $ago = new \DateTime($this->create_date);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    /**
     * [This method is used to sort task list. Create 2 arrays, one containing unchecked task sorted by date
        and the other containing checked tasks.  
     * @param  [array] $key [status id]
       @return array containing unchecked task at the top and check task at the bottom
     */
    public static function sortTaskList($array) {
        foreach ($array as $key => $row) {
            if ($row['status_id'] == self::TASK_COMPLETED){
              $status[] = $row;
              $statusId[] = $row['create_date'];
            }else{
              $date[] = $row;
              $dateTime[] = $row['create_date'];
            }
        }
        if(!empty($date)){
            array_multisort($dateTime, SORT_DESC, $date);
        }
        if(!empty($status)){
            array_multisort($statusId, SORT_DESC, $status);
        }
        if(!empty($date) && !empty($status)){
            return array_merge($date, $status);
        }else{
            return $array;
        }
    }

}
