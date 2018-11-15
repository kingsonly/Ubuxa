<?php

namespace frontend\controllers;
use yii;
use yii\web\Controller;
use yii\db\Expression;
use frontend\models\Component;
use frontend\models\FolderComponent;
use frontend\models\Folder;

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
		return $this->renderAjax('listview',['content'=>$getFolder->componentTemplateAsComponents]);
    }

    public function actionView($id)
    {
		$component = Component::findOne($id);
        return $this->renderAjax('view',['component'=>$component]);
    }

}
