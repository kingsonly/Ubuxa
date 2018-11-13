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
			if($model->save(false)){
				$folderComponentModel->component_id = $model->id;
				if($folderComponentModel->save(false)){
					return ['output'=>$model->id, 'message'=>'sent'];
				}
            	
			}
            
        }
		return ['output'=>1, 'message'=>'not sent'];
       
    }

    public function actionIndex($folder,$component)
    {
        return $this->renderAjax('index',[
			'folderId'=>$folder,
			'templateId'=>$component,
			'componentId'=>$component,
		]);
    }

    public function actionListview($folder,$component)
    {
		$folderModel = new Folder();
		
		
		$getFolder = $folderModel->find()->where(['id'=>$folder])->one();
		$getFolder->externalTemplateId = $component;
		var_dump($getFolder->componentTemplateAsComponents);
		//var_dump($getFolder->externalTemplateId);
		return;
       // return $this->renderAjax('listview',['content'=>$getFolder->componentTemplateAsComponents]);
    }

    public function actionView($id)
    {
        return $this->render('view');
    }

}
