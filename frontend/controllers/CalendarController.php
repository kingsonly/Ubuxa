<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Calendar;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\Task;
use frontend\models\Folder;
use frontend\models\TaskGroup;
use frontend\models\TaskGroupCheck;
use frontend\models\TaskColor;
use frontend\models\UserDb;
use frontend\models\Reminder;
use frontend\models\Email;
use frontend\models\GoogleCalendarId;
use frontend\models\CalendarCheckStatus;

/**
 * CalendarController implements the CRUD actions for Calendar model.
 */
class CalendarController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Calendar models.
     * @return mixed
     */
    public function actionIndex()
    {
            /**
             * Instatiating all the model classes 
             */
            $taskModel      = new Task(); // Instantiate the task model
            $taskColor      = new TaskColor(); // Instantiate the task color model for saving the event colors
            $gCalIdModel    = new GoogleCalendarId(); // Instantiate google calendar ID for the logged in user
            $folderModel    = new Folder(); //Instantiate folder model
            $reminderModel  = new Reminder(); //Instantiate reminder model
            
            $newTask        = $taskModel; // pass task model to a variable
            $TaskGroupModels= Task::find()->all(); // find all the task in the task model
            $person_id      = Yii::$app->user->identity->id; //get the session identity of the user
            $personId       = Yii::$app->user->identity->id; //get the session identity of the user
            $calendarTasks  = Task::find()->orderBy(['id' => SORT_ASC])->andWhere(['deleted'=>0])->andWhere(['owner'=>$personId])->all(); //find task to be rendered on the calendar based on the user
            $TaskGroupModel = TaskGroup::find()->one(); // Get all task group as event

            $taskGroupCheckModel = TaskGroupCheck::find()->andWhere(['person_id'=>$personId])->one(); //check if the task group of the user is checked
            $calendarCheckModel  = CalendarCheckStatus::find()->andWhere(['user_id'=>$personId])->one(); //check the type of calendar the user has set (ie google calendar or ubuxa calendar)
            $getTask = $folderModel->clipOn['task']; // get clip task cliped on their folders
            //get reminders
            $userId = Yii::$app->user->identity->id; //get user identity
            $userModel = UserDb::findOne($userId); // get current user data
            $reminders = $userModel->reminders; // fetch the reminder of the logged in user
            
            $gCalId = GoogleCalendarId::find()->andWhere(['user_id'=>$personId])->one(); //get email of current user for the google calendar implementation
            //get the id parameter from the url and pass it to the form for creating new event based on the folder id
            $getIdParam = yii::$app->getRequest()->getQueryParam('id');

            /*
             *on page load, loop through the reminders and push it unto an array
             *this array will be used in the javascript to append the reminder icon to their respective dates
             */
            $reminderDates = []; // define the array variable
            foreach ($reminders as $key => $value) { //loop through the reminders 
                    if($value['deleted'] == Calendar::TASK_NOT_DELETED){ //make sure the reminders to are not deleted reminders
                    $exp = explode(' ', $value->reminder_time); //explode to get just the date part of the the timestamp value
                    $reminderDates[]=$exp[0]; //get the date part
                    }
            }

            $getDateArr = json_encode($reminderDates); // convert array to json encoded array to be used by the javascript


            /*
             * return all required variables to the view
             */
            return $this->render('index', [
                'taskModel'             => $taskModel,
                'getTask'               => $getTask,
                'TaskGroupModel'        => $TaskGroupModels,
                'taskGroupCheckModel'   => $taskGroupCheckModel,
                'calendarCheckModel'    => $calendarCheckModel,
                'calendarTask'          => $calendarTasks,
                'newTask'               => $newTask,
                'taskColor'             => $taskColor,
                'reminders'             => $reminders,
                'reminderModel'         => $reminderModel,
                'personId'              => $personId,
                'gCalId'                => $gCalId,
                'gCalIdModel'           => $gCalIdModel,
                'getIdParam'            => $getIdParam,
                'getDateArr'            => $getDateArr,
            ]);
    }

    /**
     * Displays a single Calendar model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
    }

    /**
     * Creates a new Calendar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
            $model = new Calendar();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
    }

    /**
     * Updates an existing Calendar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
    }

    /**
     * Updates checkbox for remove after drop for the calendar events .
     */
    public function actionUpdateremoveafterdrop()
    {
            if(!empty(Yii::$app->request->post('id'))){ //check if id in the post variable is set
                $id = Yii::$app->request->post('id'); // pass the id in the post variable to another viariable
                $taskGroupModel = TaskGroup::find()->andWhere(['task_group_id'=>$id])->one();
                $taskGroupModel->remove_after_drop_status = Calendar::REMOVE_AFTER_DROP_STATUS; //update status to 1
                $taskGroupModel->save(); // save the update
            }
    }

    /**
     * Update the due date when event has been resized
     */
    public function actionResizeduedate()
    {
            if(!empty(Yii::$app->request->post('duedate'))){ //check if due date in the post variable is set
                $duedate = Yii::$app->request->post('duedate'); // pass duedate in the post variable to another viariable
                $id = Yii::$app->request->post('id'); //pass the id in the post variable to another viariable
                $taskModel = Task::find()->andWhere(['id'=>$id])->one();
                $taskModel->due_date = $duedate; //set the new date
                if($taskModel->save()){
                    return "success"; //if saved successfully return success message
                } else {
                    return "something went wrong"; // if not saved return a failure message
                }
            }

    }

    /**
     * Get reminders
     */
    public function actionReminders()
    {
            $reminderModel = new Reminder(); // instantiate the reminder model
            $userId = Yii::$app->user->identity->id; //get user identity
            $userModel = UserDb::findOne($userId); 
            $reminders = $userModel->reminders;
    }


     /**
     * Update start date of external task on drop
     */
    public function actionUpdateondrop()
    {
            if(!empty(Yii::$app->request->post('id'))){ //check if id in the post variable is set
                $duedate = Yii::$app->request->post('end'); // pass duedate in the post variable to another 
                $startdate = Yii::$app->request->post('start'); // pass startdate in the post variable to another 
                $id = Yii::$app->request->post('id'); // pass id in the post variable to another 
                $taskModel = Task::find()->andWhere(['id'=>$id])->one(); // find task based on the id of the dropped task
                $taskModel->due_date = $duedate; //set new due date
                $taskModel->in_progress_time = $startdate; //set new start date
                if($taskModel->save()){
                    return "success"; //if saved successfully return success message
                } else {
                    return "something went wrong"; //if not saved successfully return failure message
                }
            }

    }

    /**
     * Update start date of calendar task on drop
     */
    public function actionDrop()
    {
            if(!empty(Yii::$app->request->post('id'))){ //check if id in the post variable is set
                $id = Yii::$app->request->post('id'); // pass id in the post variable to another 
                $eventColor = Yii::$app->request->post('color'); // pass event color in the post variable to another 
                $date = Yii::$app->request->post('date'); // pass date in the post variable to another 
                $taskGroupModel = TaskGroup::find()->andWhere(['task_group_id'=>$id])->one(); //find task group
                $taskModel = Task::find()->andWhere(['id'=>$id])->one(); //find task
                $taskGroupModel->drop_task_status = 1;
                $taskModel->in_progress_time = $date;
                if($taskGroupModel->save() && $taskModel->save()){ 
                    $color = new TaskColor();
                    $color->task_group_id = $id;
                    $color->task_color = $eventColor;
                    $color->save();
                }
            }

    }

    /**
     * Update task group when checked
     */
    public function actionUpdatetaskgroupcheckurl()
    {
            $personId = Yii::$app->user->identity->id; //get user identity
            $taskGroupCheckModel = TaskGroupCheck::find()->andWhere(['person_id'=>$personId])->one(); //find the status of the task group of the current user
            if(!empty($taskGroupCheckModel)){ //check to see if this user has data in the database

                $id = Yii::$app->request->post('status'); //set status post variable to another variable
                if($taskGroupCheckModel->status == Calendar::TASK_GROUP_CHECKED){
                  $taskGroupCheckModel->status = Calendar::TASK_GROUP_NOT_CHECKED;
                  $taskGroupCheckModel->save();
                } else {
                  $taskGroupCheckModel->status = Calendar::TASK_GROUP_CHECKED;
                  $taskGroupCheckModel->save(); 
                }

            }else{ //if this user does not have data in the database add the user as new record
                $taskGroupCheck = new taskGroupCheck();
                $taskGroupCheck->status = Calendar::TASK_GROUP_CHECKED;
                $taskGroupCheck->person_id = $personId;
                $taskGroupCheck->save();
            }

    }

    /**
     * Update calendar type when checked
     */
    public function actionUpdatecalendarcheckurl()
    {
        //$taskGroupModel = new TaskGroup;
        $personId = Yii::$app->user->identity->id;
        $calendarCheckModel = CalendarCheckStatus::find()->andWhere(['user_id'=>$personId])->one(); //find the status of the task group of the current user
        if(!empty($calendarCheckModel)){

            $id = Yii::$app->request->post('status');
            //check to update the task group based on whether checked or not
            if($calendarCheckModel->status == Calendar::GOOGLE_CALENDAR){
              $calendarCheckModel->status = Calendar::UBUXA_CALENDAR; //set calendar status to ubuxa
              $calendarCheckModel->save();
            } else {
              $calendarCheckModel->status = Calendar::GOOGLE_CALENDAR; //set calendar status to google calendar
              $calendarCheckModel->save(); 
            }

        }else{
            $calendarCheck = new CalendarCheckStatus(); //instatiate the CalendarCheckStatus model
            $calendarCheck->status = Calendar::GOOGLE_CALENDAR;
            $calendarCheck->user_id = $personId;
            $calendarCheck->save();
        }

    }

   

    /**
     * Deletes an existing Calendar model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
    }

    /**
     * Get the task list for each of the task group(ie events) on the google calendar
     */
    public function actionTaskgrouptask()
    {
            $taskGroupId = Yii::$app->request->post('id'); //this holds the task group id on clik of the view date
            $taskGroup = TaskGroup::find()->andWhere(['task_group_id'=>$taskGroupId])->one(); // this should hold the relationship needed to fetch the tasks under this group
            //return required variable to the view
            return $this->renderAjax('calendartask', [
                'taskGroupId'   => $taskGroupId,
                'taskGroup'     => $taskGroup, // this would be changed as soon as it works
            ]);
    }

    /**
     * Method to get the user reminder set on the calendar
     */
    public function actionReminder()
    {
            if(Yii::$app->request->post('date')){ //check whether the date to set the reminder isset
                $date = Yii::$app->request->post('date'); //this holds the date that the reminder will be set to
                $reminderModel = new Reminder(); //instatiate the reminder model
                $userId = Yii::$app->user->identity->id; //get the identity of current user
                $userModel = UserDb::findOne($userId); //find the user
                $reminders = $userModel->reminders; //get reminders of the user
                //return all required variables to the view
                return $this->renderAjax('reminder', [
                    'reminders'      => $reminders,
                    'reminderModel'  => $reminderModel,
                    'date'           => $date,
                ]);
            }
    }

    /**
     * Method to create the google calendar ID of user
     */
    public function actionCreatecalendarid()
    {
            $calendarId = new GoogleCalendarId(); //instatiate the google calendar id model
            $userId = Yii::$app->user->identity->id; // get teh cureent user
            $calendarId->user_id = $userId; //set user ID
            if ($calendarId->load(Yii::$app->request->post()) && $calendarId->save()) {
                return 'saved'; //if saved successfully return a success message
            }
    }



    /**
     * Finds the Calendar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Calendar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
            if (($model = Calendar::findOne($id)) !== null) {
                return $model;
            }

            throw new NotFoundHttpException('The requested page does not exist.');
    }
}
