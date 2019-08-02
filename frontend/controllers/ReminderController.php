<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Reminder;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use frontend\models\TaskReminder;
use frontend\models\CalendarReminder;
use frontend\models\UserDb;
use boffins_vendor\classes\BoffinsBaseController;
/**
 * ReminderController implements the CRUD actions for Reminder model.
 */
class ReminderController extends Controller
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
     * Lists all Reminder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Reminder::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Reminder model.
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
     * Creates a new Reminder model.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Reminder();
        $presentTime = new Expression('NOW()');
		$model->last_updated = $presentTime;
		$taskReminder = new TaskReminder();
        $calendarModel = new CalendarReminder();

        if ($model->load(Yii::$app->request->post()) and $taskReminder->load(Yii::$app->request->post()) && $model->save()) {
         
                    $taskReminder->reminder_id = $model->id;
                    $taskReminder->save(false);

                     return $this->renderAjax('create', [
                             'model' => $model,
                         ]);
                    
                }
        /*
         * This next block of if statement is when the reminder is created from calendar
         */
        if (!empty(Yii::$app->request->post('date'))) { //check whther the date in the post variable is set
            $postVariable = Yii::$app->request->post();
            $time = $postVariable["Reminder"]["reminder_time"]; //get the time from the form
            $matchTime = preg_match("/^(?:2[0-4]|[01][1-9]|10):([0-5][0-9])$/", $time); 

            //check whether the time sent matches with the format required. if not return a status 0
            if(preg_match("/^(?:2[0-4]|[01][1-9]|10):([0-5][0-9])$/", $time)){
                //get the time to timestamp format
                $model->reminder_time = Yii::$app->request->post('date') . " " .$time.":00"; 
                if($model->save()){ //if save also save the reminder id in the calendar reminder model
                    $calendarModel->reminder_id = $model->id;
                    $calendarModel->user_id = Yii::$app->user->identity->id;
                    $calendarModel->save();
                    //return an array of required data to be used in the view
                    return json_encode([$model->id,$model->notes,$model->reminder_time]); 
                }
            } else {
                return 0; //time format did not match the required format
            }          
        }
    }

    /**
     * Updates an existing Reminder model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
         
        $model = $this->findModel($id);
        if (isset($_POST['hasEditable'])) {

        // use Yii's response format to encode output as JSON
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // read your posted model attributes
        if ($model->load(Yii::$app->request->post())) {
            // read or convert your posted information
            
           if($model->save(false)){
                 yii::trace('i got here');
                return ['output'=>'', 'message'=>''];
           } 
            // return JSON encoded output in the below format
           
            // alternatively you can return a validation error
            // return ['output'=>'', 'message'=>'Validation error'];
        }
        // else if nothing to do always return an empty JSON encoded output
        else {
             yii::trace('this is b4 else');
            return ['output'=>'not sent', 'message'=>''];
        }
        }

        //Block of code to update the reminder
        $postVariable = Yii::$app->request->post();
        $time = $postVariable["Reminder"]["reminder_time"];
        $timestamp = Yii::$app->request->post('date')." ".$time;
        if ($model->load(Yii::$app->request->post())) {
            $model->reminder_time = $timestamp;
            $model->save();
            return 1; //status used in the view
        } else {
            return 2; //status used in the view
        }
    }

    /**
     * Deletes an existing Reminder model.
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
     * This method is used to display the data on the form based on the reminder that was clicked
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdatereminder()
    {
        $model = Reminder::find()->where(['id'=>Yii::$app->request->post('id')])->one();
        //return json encoded array to be used in the view
        return json_encode(array($model->notes, $model->reminder_time));
    }

    /**
     * This method is used to delete the calendar reminder by setting its status to 1
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeletecalendarreminder()
    {
        if(Yii::$app->request->post('id')) {
            $status_deleted = 1; // task was deleted successfully status
            $status_not_deleted = 2; // task was deleted unsuccessfully status
            $reminderId = Yii::$app->request->post('id');
            $deleteReminder = Reminder::findOne($reminderId);
            $deleteReminder->deleted = Reminder::REMINDER_DELETED;
            if($deleteReminder->save()){
                return $status_deleted;
            }else{
                return $status_not_deleted;
            }
        }
    }

    /**
     * Finds the Reminder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reminder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reminder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
