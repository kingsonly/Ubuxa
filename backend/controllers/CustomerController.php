<?php

namespace backend\controllers;

use Yii;
use frontend\models\Customer;
use common\models\UserDevicePushToken;
use backend\models\UserDb;
use backend\models\EmailModel;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
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
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
		$this->layout = 'dashboardtwo';
		
        $dataProvider = new ActiveDataProvider([
            'query' => Customer::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		$this->layout = 'dashboardtwo';
		
		$model = $this->findModel($id);
		$customerFolders = $model->customerFolders;
		$customerTasks = $model->customerTasks;
		$customerDocuments = $model->customerDocuments;
		$customerUsers = $model->customerUsersBackend;
		
        return $this->render('view', [
            'model' => $model,
			'customerFolders' => count($customerFolders),
			'customerTasks' => count($customerTasks),
			'customerDocuments' => count($customerDocuments),
			'customerUsers' => count($customerUsers),
			'users' => $customerUsers,
        ]);
    }
	
	public function actionUserView($id)
    {
		$this->layout = 'dashboardtwo';
		
		$model = UserDb::find()->where(['id' => $id])->one();
		
        return $this->render('userview', [
            'model' => $model,
			
        ]);
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$this->layout = 'dashboardtwo';
		
        $model = new Customer();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
	
	
	public function actionSendCustomerUsersEmail($id)
    {
		$this->layout = 'dashboardtwo';
		
        $model = $this->findModel($id);
		$customerUsers = $model->customerUsersBackend;
		$emails = [];
		$emailModel = new EmailModel();
		if(!empty($customerUsers)){
			foreach( $customerUsers as $key => $value){
			    array_push($emails, $value->email);
			}
		}
		
        if ($emailModel->load(Yii::$app->request->post())) {
			if(!empty($emails)){
				$model->sendCustomerEmail($emails,$emailModel->body,$emailModel->subject);
				Yii::$app->session->setFlash('success', "your email has been sent to.");
			}
           
        }

        return $this->render('sendemail', [
            'model' => $emailModel,
            'users' => $customerUsers,
        ]);
    }
	
	
	
	public function actionSendCustomerEmail($id)
    {
		$this->layout = 'dashboardtwo';
		
        $model = $this->findModel($id);
		$customerUsers = $model->customerUsersBackend;
		$emailModel = new EmailModel();
		
        if ($emailModel->load(Yii::$app->request->post())) {
			if(!empty($model->master_email)){
				$model->sendCustomerEmail($model->master_email,$emailModel->body,$emailModel->subject);
				Yii::$app->session->setFlash('success', "your email has been sent to.");
			}
           
        }

        return $this->render('sendemail', [
            'model' => $emailModel,
            'users' => $model->master_email,
        ]);
    }
	
	public function actionSendUserEmail($id)
    {
		$this->layout = 'dashboardtwo';
		
        $model = UserDb::findOne($id);
		$emailModel = new EmailModel();
		
        if ($emailModel->load(Yii::$app->request->post())) {
			if(!empty($model->email)){
				Customer::sendCustomerEmail($model->email,$emailModel->body,$emailModel->subject);
				Yii::$app->session->setFlash('success', "your email has been sent to.");
			}
           
        }

        return $this->render('sendemail', [
            'model' => $emailModel,
            'users' => $model,
        ]);
    }
	
	
	
	public function actionSendCustomerUsersPushNotification($id)
    {
		$this->layout = 'dashboardtwo';
		
        $model = $this->findModel($id);
		$customerUsers = $model->customerUsersBackend;
		$emailModel = new EmailModel();
		$pushToken = [];
		
		if(!empty($customerUsers)){
			foreach( $customerUsers as $key => $value){
				foreach($value->pushToken as $tokenKey => $tokenValue ){
					array_push($pushToken, $tokenValue->push_token);
				}
			    
			}
		}
		
        if ($emailModel->load(Yii::$app->request->post())) {
			if(!empty($pushToken)){
				$model->sendCustomerPushNotification($pushToken,$emailModel->body,$emailModel->subject);
				Yii::$app->session->setFlash('success', "your email has been sent to.");
			}
           
        }

        return $this->render('sendemail', [
            'model' => $emailModel,
            'users' => $model->master_email,
        ]);
    }
	
	
	
	public function actionSendCustomerPushNotification($id)
    {
		$this->layout = 'dashboardtwo';
		
        $model = $this->findModel($id);
		$customerUsers = $model->customerUsersBackend;
		$emailModel = new EmailModel();
		$pushToken = [];
		
		if(!empty($customerUsers)){
			$i = 0;
			if($i <= 1){
				foreach( $customerUsers as $key => $value){
					foreach($value->pushToken as $tokenKey => $tokenValue ){
						array_push($pushToken, $tokenValue->push_token);
					}
			    $i++;
				}
			}
			
		}
		
        if ($emailModel->load(Yii::$app->request->post())) {
			if(!empty($pushToken)){
				$model->sendCustomerPushNotification($pushToken,$emailModel->body,$emailModel->subject);
				Yii::$app->session->setFlash('success', "your email has been sent to.");
			}
           
        }

        return $this->render('sendemail', [
            'model' => $emailModel,
            'users' => $model->master_email,
        ]);
    }
	
	
	public function actionSendUserPushNotification($id)
    {
		$this->layout = 'dashboardtwo';
		
        $model = UserDb::findOne($id);
		$emailModel = new EmailModel();
		$pushToken = [];
		
		if(!empty($model)){
				
			foreach($model->pushToken as $tokenKey => $tokenValue ){
				array_push($pushToken, $tokenValue->push_token);
			}
			    
			}
		
		
        if ($emailModel->load(Yii::$app->request->post())) {
			if(!empty($pushToken)){
				$model->sendCustomerPushNotification($pushToken,$emailModel->body,$emailModel->subject);
				Yii::$app->session->setFlash('success', "your message has been sent to.");
			}else{
				Yii::$app->session->setFlash('success', "this User Is not a mobile app User.");
			}
           
        }

        return $this->render('sendemail', [
            'model' => $emailModel,
            'users' => $model,
        ]);
    }
	
	public function actionSendAllCustomerUsersEmail()
    {
		$this->layout = 'dashboardtwo';
		
        $model = UserDb::find()->all();
		$customerUsers = $model;
		$emails = [];
		$emailModel = new EmailModel();
		if(!empty($customerUsers)){
			foreach( $customerUsers as $key => $value){
			    array_push($emails, $value->email);
			}
		}
		
        if ($emailModel->load(Yii::$app->request->post())) {
			if(!empty($emails)){
				Customer::sendCustomerEmail($emails,$emailModel->body,$emailModel->subject);
				Yii::$app->session->setFlash('success', "your email has been sent to.");
			}
           
        }

        return $this->render('sendemail', [
            'model' => $emailModel,
            'users' => $customerUsers,
        ]);
    }
	
	public function actionSendAllCustomerEmail()
    {
		$this->layout = 'dashboardtwo';
		
        $model = Customer::find()->all();
		$emails = [];
		$emailModel = new EmailModel();
		foreach($model as $emailKey => $emailValue){
			array_push($emails, $emailValue->master_email);
		}
		
        if ($emailModel->load(Yii::$app->request->post())) {
			if(!empty($emails)){
				Customer::sendCustomerEmail($emails ,$emailModel->body,$emailModel->subject);
				Yii::$app->session->setFlash('success', "your email has been sent to.");
			}
           
        }

        return $this->render('sendemail', [
            'model' => $emailModel,
            'users' => $model,
        ]);
    }
	
	
	
	public function actionSendAllCustomerUsersPushNotification()
    {
		$this->layout = 'dashboardtwo';
		
        $model = UserDevicePushToken::find()->all();
		$customerUsers = $model;
		$emailModel = new EmailModel();
		$pushToken = [];
		
		if(!empty($customerUsers)){
			foreach( $customerUsers as $key => $value){
				
				array_push($pushToken, $value->push_token);
				
			    
			}
		}
		
        if ($emailModel->load(Yii::$app->request->post())) {
			if(!empty($pushToken)){
				Customer::sendCustomerPushNotification($pushToken,$emailModel->body,$emailModel->subject);
				Yii::$app->session->setFlash('success', "your email has been sent to.");
			}
           
        }

        return $this->render('sendemail', [
            'model' => $emailModel,
            'users' => $pushToken,
        ]);
    }
	
	
	
	public function actionSendAllCustomerPushNotification()
    {
		$this->layout = 'dashboardtwo';
		
        $model = Customer::find()->all();
		$emailModel = new EmailModel();
		$pushToken = [];
		
		if(!empty($model)){
			
			foreach($model as $customerKey => $customerValue){
				$i = 0;
				if($i <= 1){
					foreach( $customerValue->customerUsers as $key => $value){
						foreach($value->pushToken as $tokenKey => $tokenValue ){
							array_push($pushToken, $tokenValue->push_token);
						}
					$i++;
					}
				}
			}
			
			
		}
		
        if ($emailModel->load(Yii::$app->request->post())) {
			if(!empty($pushToken)){
				Customer::sendCustomerPushNotification($pushToken,$emailModel->body,$emailModel->subject);
				Yii::$app->session->setFlash('success', "your email has been sent to.");
			}
           
        }

        return $this->render('sendemail', [
            'model' => $emailModel,
            'users' => $pushToken,
        ]);
    }


    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		$this->layout = 'dashboardtwo';
		
        $model = $this->findModel($id);
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            
        ]);
    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		$this->layout = 'dashboardtwo';
		
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
