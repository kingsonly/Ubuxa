<?php

namespace frontend\controllers;
use yii;
use yii\web\Controller;
use yii\db\Expression;
use frontend\models\Component;
use frontend\models\FolderComponent;
use frontend\models\Folder;
use boffins_vendor\classes\ModelCollection;
use frontend\models\ComponentAttributeModel;

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
		$getFolder = $folderModel->find()->where(['id'=>$folder])->one();
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
		$getFolder = $folderModel->find()->where(['id'=>$folder])->one();
		$getFolder->externalTemplateId = $component;
		$collector = new ModelCollection( [], [ 'query' => $getFolder->getComponentTemplateAsComponents() ] );
		$modelData = $collector->models;

		return $this->renderAjax('listview',['content'=>$modelData]);
    }
	

    public function actionView($id)
    {
		/*$componentModel = new Component();
		$component = $componentModel->find()->where(['id'=>$id]);
		$collector = new ModelCollection( [], [ 'query' => $component ] );
		$modelData = $collector->models;*/
		$folder = new Folder();
		$getting = $folder->find()->where(['id' => 30])->one();
		$getti = $getting->folderUsers;
		
		$componentModel = new Component();
		$query = $componentModel->find()->where(['id'=>$id]);
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
				
				return ['output'=>$model->value, 'message'=>'','component' => $id];
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
			'fuser'=>$component->componentUsers,
		]);
    }
	
	public function actionUpdate($id)
    {
		
		if (isset($_POST['hasEditable'])) {
			$component = Component::find()->where(['id'=>id]);
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

}
