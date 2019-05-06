<?php

namespace frontend\controllers;
use yii;
use yii\web\Controller;
use yii\db\Expression;
use frontend\models\Component;
use frontend\models\ComponentAttribute;
use frontend\models\FolderComponent;
use frontend\models\Folder;
use boffins_vendor\classes\ModelCollection;
use frontend\models\ComponentAttributeModel;
use frontend\models\InviteUsers;
use frontend\models\UserDb;
use boffins_vendor\queue\FolderUsersQueue;
use boffins_vendor\classes\BoffinsBaseController;

class ComponentController extends Controller
{
    public function actionCreate()
    {
		 $model = new Component();
		 $folderComponentModel = new FolderComponent();
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($model->load(Yii::$app->request->post()) && $folderComponentModel->load(Yii::$app->request->post())) {
			$model->last_updated =  new Expression('NOW()');
			$model->folderId =  $folderComponentModel->folder_id;
			if($model->save(false)){
				$folderComponentModel->component_id = $model->id;
				if($folderComponentModel->save(false)){
					return ['output'=>$model->id, 'message'=>'sent','area'=>'component','templateId'=>$model->component_template_id];
				}
            	
			}
            
        }
		return ['output'=>1, 'message'=>'not sent','area'=>'component','templateId'=>'0'];
       
    }

    public function actionIndex($folder,$component)
    {
		$folderModel = new Folder();
		$getFolder = $folderModel->find()->andWhere(['id'=>$folder])->one();
		$getFolder->externalTemplateId = $component;
        return $this->renderAjax('index',[
			'folderId'=>$folder,
			'templateId'=>$component,
			'componentId'=>$getFolder->componentTemplateAsComponents[0],
		]);
    }

    public function actionListview($folder,$component)
    {
		$folderModel = new Folder();
		$getFolder = $folderModel->find()->andWhere(['id'=>$folder])->one();
		$getFolder->externalTemplateId = $component;
		$collector = new ModelCollection( [], [ 'query' => $getFolder->getComponentTemplateAsComponents() ] );
		$modelData = $collector->models;

		return $this->renderAjax('listview',['folder' => $folder,'content'=>$modelData]);
    }
	

    public function actionView($id,$folderId)
    {
		/*$componentModel = new Component();
		$component = $componentModel->find()->andWhere(['id'=>$id]);
		$collector = new ModelCollection( [], [ 'query' => $component ] );
		$modelData = $collector->models;*/
		$folder = new Folder();
		$getCurrentFolder = $folder->find()->andWhere(['id' => $folderId])->one();
		$getFolderUsers = $getCurrentFolder->users;
		
		$componentModel = new Component();
		$query = $componentModel->find()->andWhere(['id'=>$id]);
		$component = $query->one();
		$collector = new ModelCollection( [], [ 'query' => $query ] ); //using the relation
		$modelData = $collector->models;
			if (isset($_POST['hasEditable'])) {
				Yii::trace("hash Eduted");
		
			// use Yii's response format to encode output as JSON
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

			// read your posted model attributes
				$collectors = new ModelCollection( [], [ 'query' => $component->getComponentAttributes() ] ); 
				$model = new ComponentAttributeModel();
				$model->load(Yii::$app->request->post());
				$collectors->loadModel($model->attributeId,['value'=>$model->value]);
				
			if ($collectors->saveModel($model->attributeId)) {
				
				return ['output'=>'', 'message'=>'','component' => $id];
			}
			// else if nothing to do always return an empty JSON encoded output
			else {
				return ['output'=>$model->attributeId, 'message'=>'4321', 'component-id' => ''];
			}
    }
        return $this->renderAjax('view',[
			'component'=>$component,
			'content'=>$modelData,
			'users'=>$component->componentUsers,
			'fuser'=>$getFolderUsers,
		]);
    }
	
	public function actionUpdate($id)
    {
		
		if (isset($_POST['hasEditable'])) {
			$component = Component::find()->andWhere(['id'=>id]);
			$collector = new ModelCollection( [], [ 'query' => $component ] );
			$modelData = $collector->models;
			// use Yii's response format to encode output as JSON
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

			// read your posted model attributes
			if ($model->load(Yii::$app->request->post())) {
				
				return ['output'=>'', 'message'=>''];
			}
			// else if nothing to do always return an empty JSON encoded output
			else {
				return ['output'=>'', 'message'=>''];
			}
    	}
        return $this->renderAjax('view',['component'=>$modelData]);
    }
	
	/*
	To be used once queue is fixed 
	public function actionAddUsers($id) {
		$inviteUsersModel = new InviteUsers();
		$userModel = new UserDb();
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		 if ($inviteUsersModel->load(Yii::$app->request->post())) {
			  
			 foreach($inviteUsersModel->users as $value){
				 $getUserId = $userModel->find()->select(['id'])->andWhere(['person_id' => $value])->one();
				 $test = $getUserId['id'];
				 Yii::$app->queue->push(new FolderUsersQueue([
					'userId' => $getUserId['id'],
					'componentId' => $id,
					'type' => 'component',
				]));
			 }
            return ['output'=>$id, 'message'=> 0];
        }
	} */
	
	
	public function actionAddUsers($id) {
		$inviteUsersModel = new InviteUsers();
		$userModel = new UserDb();
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		 if ($inviteUsersModel->load(Yii::$app->request->post())) {
			  
			 foreach($inviteUsersModel->users as $value){
				 $getUserId = $userModel->find()->select(['id'])->andWhere(['person_id' => $value])->one();
				 $test = $getUserId['id'];
				 $this->addComponentNewUser($getUserId['id'], $id);
			 }
            return ['output'=>$id, 'message'=> 0];
        }
	}
	
	
	public function actionUpdateTitle($id) 
	{
		if (isset($_POST['hasEditable'])) {
			Yii::trace("hash Eduted");
			$componentModel = new Component();
			// use Yii's response format to encode output as JSON
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

			// read your posted model attributes
				$collectors = new ModelCollection( [], [ 'query' => $componentModel->find()->andWhere(['id'=>$id]) ] ); 
				$model = new ComponentAttributeModel();
				$model->load(Yii::$app->request->post());
				$collectors->loadModel($model->attributeId,['title'=>$model->value]);
				
			if ($collectors->saveModel($model->attributeId)) {
				
				return ['output'=>$model->value, 'message'=>'','component' => $id];
			}
			// else if nothing to do always return an empty JSON encoded output
			else {
				return ['output'=>$model->attributeId, 'message'=>'4321', 'component-id' => ''];
			}
		}
	}
	
	public function actionUpdateValue($id) 
	{
		if (isset($_POST['hasEditable'])) {
			Yii::trace("hash Eduted");
			$componentModel = new ComponentAttribute();
			// use Yii's response format to encode output as JSON
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

			// read your posted model attributes
				$collectors = new ModelCollection( [], [ 'query' => $componentModel->find()->andWhere(['id'=>$id]) ] ); 
				$model = new ComponentAttributeModel();
				$model->load(Yii::$app->request->post());
				$collectors->loadModel($model->attributeId,['value'=>$model->value]);
				
			if ($collectors->saveModel($model->attributeId)) {
				
				return ['output'=>$model->value, 'message'=>'','component' => $id];
			}
			// else if nothing to do always return an empty JSON encoded output
			else {
				return ['output'=>$model->attributeId, 'message'=>'4321', 'component-id' => ''];
			}
		}
	}
	
	public function actionUpdateIntegerValue($id) 
	{
		if (isset($_POST['hasEditable'])) {
			Yii::trace("hash Eduted");
			$componentModel = new ComponentAttribute();
			// use Yii's response format to encode output as JSON
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

			// read your posted model attributes
				$collectors = new ModelCollection( [], [ 'query' => $componentModel->find()->andWhere(['id'=>$id]) ] ); 
				$model = new ComponentAttributeModel();
				$model->load(Yii::$app->request->post());
				$collectors->loadModel($model->attributeId,['value'=>(int)$model->value]);
				
			if ($collectors->saveModel($model->attributeId)) {
				
				return ['output'=>$model->value, 'message'=>'','component' => $id];
			}
			// else if nothing to do always return an empty JSON encoded output
			else {
				return ['output'=>$model->attributeId, 'message'=>'4321', 'component-id' => ''];
			}
		}
	}
	
	public function actionUpdateKnownClassValue($id) 
	{
		if (isset($_POST['hasEditable'])) {
			Yii::trace("hash Eduted");
			$componentModel = new ComponentAttribute();
			// use Yii's response format to encode output as JSON
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

			// read your posted model attributes
				$collectors = new ModelCollection( [], [ 'query' => $componentModel->find()->andWhere(['id'=>$id]) ] ); 
				$model = new ComponentAttributeModel();
				$model->load(Yii::$app->request->post());
			
				$collectors->loadModel($model->attributeId,['value'=>['condition' => 'id='.$model->value]]);
				
			if ($collectors->saveModel($model->attributeId)) {
				
				return ['output'=>'', 'message'=>'','component' => $id];
			}
			// else if nothing to do always return an empty JSON encoded output
			else {
				return ['output'=>$model->attributeId, 'message'=>'4321', 'component-id' => ''];
			}
		}
	}
	
	
	public function addComponentNewUser($userId = '', $componentId = '')
	{
		
		$componentManagerModel = new ComponentManager();
		$componentManagerModel->user_id = $userId;
		$componentManagerModel->component_id = $componentId;
		$componentManagerModel->role = 'user';
		
			
		if($componentManagerModel->save(false)){
			return true;
			
		}
	}


}
