<?php
//namespace frontend\commands;

use yii\console\Controller;
 
use Yii;
use yii\helpers\Url;

use frontend\models\Reminder;
use frontend\models\UserDbDoNotAttachDateBehavour;
use frontend\models\Task;
use frontend\models\Telephone;
use frontend\models\Taskreminder;
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
	
	function smssend($owneremail,$subacct,$subacctpwd,$sendto,$sender,$message){
        
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
	
	public function actionIndex()
	{
		
		$model = new Reminder();
		$taskReminderModel = new Taskreminder();
		$userModel = new UserDb();
		$telephoneModel = new Telephone();
		$taskModel = new Task();
		$presentTime = new Expression('NOW()');
		$getContact = $model->checkForReminders($presentTime);
		$reminderId = [];
		
		foreach($getContact as $key => $value){
			
			$reminderTaskId =$taskReminderModel->find()->where(['reminder_id' => $value->id])->one()->task_id;
			$ownerId = $taskModel->find()->where(['id' => $reminderTaskId])->one()->owner;
			$assignedToId =$taskModel->find()->where(['id' => $reminderTaskId])->one()->assigned_to;
			$note =$value->notes;
			//$ownersNumber = $userModel->find()->where(['id'=>$ownerId])->one()->id; 
			//$assignedToNumber = $userModel->find()->where(['id'=>$assignedToId])->one()->id;
			$ownerNumber = $telephoneModel->numberFromUser($ownerId);
			$assignedToNumber = $telephoneModel->numberFromUser($assignedToId);
			array_push($reminderId,$value->id);
			$owneremail = "kingsonly13c@gmail.com";
			$subacct = 'KINGSONLY';
			$subacctpwd = "firstoctober" ;
			$sender = "Ubuxa";
			$message = 'Reminder from tycol main portal '.$note;
			$this->smssend($owneremail,$subacct,$subacctpwd,$ownersNumber,$sender,$message);
			$this->smssend($owneremail,$subacct,$subacctpwd,$assignedToNumber,$sender,$message);
			$updateReminderStatus = Reminder::findOne($value->id);
			$updateReminderStatus->deleted = 1;
			$updateReminderStatus->save(false);
			
		}
		
            
            
	}
}






