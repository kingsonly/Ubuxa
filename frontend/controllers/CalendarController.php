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
        $taskModel = new Task();
        $taskColor = new TaskColor();
        $dataProvider = new ActiveDataProvider([
            'query' => Calendar::find(),
        ]);
        $newTask = $taskModel;
        $TaskGroupModels = Task::find()->all();
        $calendarTasks = Task::find()->orderBy(['id' => SORT_ASC])->all();;
        $TaskGroupModel = TaskGroup::find()->one();
        $personId = Yii::$app->user->identity->id;
        $taskGroupCheckModel = TaskGroupCheck::find()->andWhere(['person_id'=>$personId])->one();

        $folderModel = new Folder();
        $getTask = $folderModel->clipOn['task'];
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'taskModel'    => $taskModel,
            'getTask'    => $getTask,
            'TaskGroupModel'        => $TaskGroupModels,
            'taskGroupCheckModel'        => $taskGroupCheckModel,
            'calendarTask'        => $calendarTasks,
            'newTask'        => $newTask,
            'taskColor'        => $taskColor,
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

    public function actionUpdateremoveafterdrop()
    {
        //$taskGroupModel = new TaskGroup;
        if(!empty(Yii::$app->request->post('id'))){
            $id = Yii::$app->request->post('id');
            $taskGroupModel = TaskGroup::find()->andWhere(['task_group_id'=>$id])->one();
            $taskGroupModel->remove_after_drop_status = 1;
            $taskGroupModel->save();
        }

    }

    public function actionResizeduedate()
    {
        //$taskGroupModel = new TaskGroup;
        if(!empty(Yii::$app->request->post('duedate'))){
            $duedate = Yii::$app->request->post('duedate');
            $id = Yii::$app->request->post('id');
            $taskModel = Task::find()->andWhere(['id'=>$id])->one();
            $taskModel->due_date = $duedate;
            if($taskModel->save()){
                return 1;
            } else {
                return 2;
            }
        }

    }

    public function actionUpdateondrop()
    {
        //$taskGroupModel = new TaskGroup;
        if(!empty(Yii::$app->request->post('id'))){
            $duedate = Yii::$app->request->post('end');
            $startdate = Yii::$app->request->post('start');
            $id = Yii::$app->request->post('id');
            $taskModel = Task::find()->andWhere(['id'=>$id])->one();
            $taskModel->due_date = $duedate;
            $taskModel->in_progress_time = $startdate;
            if($taskModel->save()){
                return 1;
            } else {
                return 2;
            }
        }

    }

    public function actionDrop()
    {
        //$taskGroupModel = new TaskGroup;
        if(!empty(Yii::$app->request->post('id'))){
            $id = Yii::$app->request->post('id');
            $eventColor = Yii::$app->request->post('color');
            $date = Yii::$app->request->post('date');
            $taskGroupModel = TaskGroup::find()->andWhere(['task_group_id'=>$id])->one();
            $taskModel = Task::find()->andWhere(['id'=>$id])->one();
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

    public function actionUpdatetaskgroupcheckurl()
    {
        //$taskGroupModel = new TaskGroup;
        $personId = Yii::$app->user->identity->id;
        $taskGroupCheckModel = TaskGroupCheck::find()->andWhere(['person_id'=>$personId])->one();
        if(!empty($taskGroupCheckModel)){

            $id = Yii::$app->request->post('status');
            if($taskGroupCheckModel->status == 1){
              $taskGroupCheckModel->status = 0;
              $taskGroupCheckModel->save();
            } else {
              $taskGroupCheckModel->status = 1;
              $taskGroupCheckModel->save(); 
            }

        }else{
            $taskGroupCheck = new taskGroupCheck();
            $taskGroupCheck->status = 1;
            $taskGroupCheck->person_id = $personId;
            $taskGroupCheck->save();
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
    public function actionTaskgrouptask()
    {
        $taskGroupId = Yii::$app->request->post('id'); //this holds the task group id on clik of the view date
        $taskGroup = TaskGroup::find()->andWhere(['task_group_id'=>$taskGroupId])->one(); // this should hold the relationship needed to fetch the tasks under this group
        
        return $this->renderAjax('calendartask', [
            //'model' => $model,
            'taskGroupId' => $taskGroupId,
            'taskGroup' => $taskGroup, // this would be changed as soon as it works
        ]);
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
