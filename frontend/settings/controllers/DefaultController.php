<?php

namespace frontend\settings\controllers;
use yii\web\Controller;
use yii\helpers\Url;
use yii\helpers\Json;
use frontend\models\UserDb;
use frontend\models\AccessPermission;
use frontend\models\ControllerBaseRoute;
use frontend\models\UserRouteAccess;
use frontend\models\UserSetting;
use frontend\settings\models\Settings;
use yii\web\UploadedFile;
use frontend\models\UploadForm;



/**
 * Default controller for the `settings` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
		// Find all users related to the admin
		$users = UserDb::find()->where(['cid' => \Yii::$app->user->identity->cid])->andWhere(['!=','id',\Yii::$app->user->identity->id])->all();
		$settingsModel = new UserSetting();
		$settings = $settingsModel->find()->where(['id'=>\Yii::$app->user->identity->cid])->one();
		$models =  new UploadForm();
		if($settings->load(\Yii::$app->request->post())){
			$settings->save(false);
		}

        return $this->renderAjax('index',[
			'users'=>$users,
			'settings' => $settings,
			'settingsModel' => $settingsModel,
			'models' => $models,
		]);
    }
	
	/**
     * Renders the CreatePrivilege view for the module
     * @return string
     */
	public function actionCreatePrivilege($id)
    {
		// init users model
		$model = new UserDb();
		$getUserDetails = $model->findAll($id); // Fetch user details
		$modelControllerBaseRoute = new ControllerBaseRoute();//init ControllerBaseRoute
		$getAllRoutes = $modelControllerBaseRoute->find()->all(); // fetch all base routes in the db 
		$model2 = $model->findOne($id);
		if($model2->load(\Yii::$app->request->post())){
			//$POST_VARIABLE=\Yii::$app->request->post('UserDb');
			//$request = $POST_VARIABLE['roles'];
			//$totalAccessCount = array_sum($request);
			
			//$model->basic_role = 4;//$totalAccessCount;
			if($model2->save(false)){
				return $model->basic_role;
			}
			
		}
		
		
        return $this->render('create',[
			'userDetails' => $getUserDetails,
			'allRoutes' => $getAllRoutes,
			'id' => $id,
			'model' => $model,
		]);
    }
	
	public function actionGetrouteform($id,$route)
	{
		return 1;
	}
	
	/**
     * uploads the new image for logo
     * @return string
     */
	public function actionSetlogo()
	{
		$uploadFormModel = new UploadForm();
		$model =  Settings::find()->where(['id' => \Yii::$app->user->identity->cid])->one();

		if(\Yii::$app->user->identity->basic_role == 1 || \Yii::$app->user->identity->basic_role == 2){
			if (\Yii::$app->request->isPost) {
					$uploadFormModel->imageFile = UploadedFile::getInstance($uploadFormModel, 'imageFile');
				if($uploadFormModel->imageFile){
					$ext = $uploadFormModel->imageFile->extension;
					$newName = \Yii::$app->security->generateRandomString().".{$ext}";
					$basePath = explode('/',\Yii::$app->basePath);
					\Yii::$app->params['uploadPath'] = \Yii::$app->basePath.'/web/images/';
					$path = \Yii::$app->params['uploadPath'] . $newName;
					$dbpath = 'images/' . $newName;
				if ($uploadFormModel->upload($path)) {
					$model->logo = $dbpath;
					if($model->save(false)){
						exit(json_encode(array("status" => 1, "msg" => "Completed")));
						return $this->render('index2');
					}

					// file is uploaded successfully
				   return $this->render('index2'); 
				}
			}
				//return $this->render('index2');
			}
		}else{
			exit(json_encode(array("status" => 2, "msg" => "You don't have permision")));
		}
        
        //$model->setScenario('insert'); // Note! Set upload behavior scenario.
		//if( $model->load(\Yii::$app->request->post()) && ){
			//$this->redirect = Url::to(['index']);
			//echo \Yii::$app->user->identity->id;
			//return $this->render('index2');
		//}
        
      
    }
	
	/**
     * this function take value from the database and breakes it down to the minimum access level
     * @return string
     */
	private function containsPermission($accessLevel, $permision, $allPermissions = []) 
	{
		if ( $permision == $accessLevel ) {
			return true;
		}
		
		if ( $permision > $accessLevel ) {
			return false;
		}
		
		if ( empty($allPermissions) ) { //this should only run once. 
			$allPermissions = AccessPermission::find()->all();
			usort($allPermissions, array($this, "_permissionSort"));
		}
		
		$currentPermission = array_pop($allPermissions);
		
		if ($currentPermission->access_value == $permision) {
			return true;
		}
		
		return $accessLevel - $currentPermission->access_value > 0 ? $this->containsPermission(  $accessLevel - $currentPermission->access_value, $permision, $allPermissions ) : $this->containsPermission(  $accessLevel, $permision, $allPermissions );
	}
	
	/**
     * sorts access permission from the smallest to the bigest as such its done in a desending order.
     * @return string
     */
	private function _permissionSort($a, $b) 
	{
		if ( !( $a instanceof AccessPermission ) || !( $b instanceof AccessPermission ) ) {
			trigger_error('Can only compare agains items of AccessPermission! (' . __METHOD__ . ')', E_USER_NOTICE); 
		}
		
		if ( $a->access_value == $b->access_value ) {
			return 0;
		}
		
		return $a->access_value < $b->access_value ? -1 : 1;
	}
}
