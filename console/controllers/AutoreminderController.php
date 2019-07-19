<?php
//namespace frontend\commands;
namespace console\controllers;

use yii\console\Controller;
 
use Yii;
use yii\helpers\Url;

use frontend\models\Reminder;
use frontend\models\UserDb;
use frontend\models\Task;
use frontend\models\Telephone;
use frontend\models\TaskReminder;
use yii\data\ActiveDataProvider;
use yii\console\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
 
/**
 * Test controller
 */
class AutoreminderController extends Controller {
	
	public function init() {
		
        parent::init();
        
    }
	
	function smsSend($owneremail,$subacct,$subacctpwd,$sendto,$sender,$message){
        
		$url =
		"http://www.smslive247.com/http/index.aspx?" . "cmd=sendquickmsg"
		. "&owneremail=" . UrlEncode($owneremail)
		. "&subacct=" . UrlEncode($subacct)
		. "&subacctpwd=" . UrlEncode($subacctpwd) . "&message=" . UrlEncode($message)."&sendto=".UrlEncode($sendto)."&sender=".UrlEncode('kings2');
		/* call the URL */



		if ($f = @fopen($url, "r")){ 
			$answer = fgets($f, 255);
			if (substr($answer, 0, 1) == "+"){
				echo "SMS to $dnr was successful.";
			} elseif($answer){
				echo 1;
			} else {
				echo 1;
			}
		} else {
			echo 0;
		}


        
        //send email
    }

    function sendEmail($assignee,$message,$taskTitle)
    {
    	return Yii::$app->mailer->compose(['html' => 'newreminder'], [
            'message' => $message, 'taskTitle' => $taskTitle
        ])
            ->setTo($assignee)
            ->setFrom([\Yii::$app->params['supportEmail'] => 'Ubuxa'])
            ->setSubject('Reminder')
            ->send();
    }


    function sendOwnerEmail($ownerEmail,$message,$taskTitle)
    {
    	return Yii::$app->mailer->compose(['html' => 'newreminder'], [
            'message' => $message, 'taskTitle' => $taskTitle
        ])
            ->setTo($ownerEmail)
            ->setFrom([\Yii::$app->params['supportEmail'] => 'Ubuxa'])
            ->setSubject('Reminder')
            ->send();
    }

    function updateReminder($value)
    {
    	$updateReminderStatus = Reminder::findOne($value->id);
		$updateReminderStatus->deleted = Reminder::REMINDER_SENT;
		$updateReminderStatus->save(false);
    }
	
	public function actionIndex()
	{
		$model = new Reminder();
		$taskReminderModel = new TaskReminder();
		$taskModel = new Task();
		$presentTime = new Expression('NOW()');
		$getContact = $model->checkForReminders($presentTime);
		
		if(!empty($getContact)){
			foreach($getContact as $key => $value){
				$message = $value->notes;
				$reminderTaskIds = $taskReminderModel->find()->where(['reminder_id' => $value->id])->one();
				$reminderTaskId = $reminderTaskIds['task_id'];
				$getTask = Task::findOne($reminderTaskId);
				$taskTitle = $getTask->title;
				$owner = $taskModel->find()->where(['id' => $reminderTaskId])->one();
				$ownerId = $owner->owner;
				$user = UserDb::findOne($ownerId);
				$ownerEmail = $user->email;
				$assignees = $getTask->taskAssigneesUserId;

				if(!empty($assignees)){
					foreach ($assignees as $key => $values) {
						$assignee = UserDb::findOne($values);
						$assigneeEmail = $assignee->email;
						if($values != $ownerId){
							$this->sendEmail($assigneeEmail, $message, $taskTitle);
						}
					}
					$this->sendOwnerEmail($ownerEmail, $message, $taskTitle);
					$this->updateReminder($value);
				}else{
					$this->sendOwnerEmail($ownerEmail, $message, $taskTitle);
					$this->updateReminder($value);
				}				
			}
		}
     
	}
}






