<?php

namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use frontend\models\Remark;
use frontend\models\RemarkSearch;

class RemarkComponentViewWidget extends Widget
{

	public function actionIndex()
    {
        $perpage=4;
        if(isset($_GET['src'])){
		        $searchModel = new RemarkSearch();
		        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		        
		        //$popsis = (($numpage-1) * $perpage);
		        if(Yii::$app->request->post('page')){
		            $numpage = Yii::$app->request->post('page');
		            $popsisi = (($numpage-1) * $perpage);
		            $remarks = Remark::find()->limit($perpage)->offset($popsisi)->all();
		            return $this->renderAjax('index2', [
		            //'searchModel' => $searchModel,
		            //'dataProvider' => $dataProvider,
		            'remarks' => $remarks,
		        ]);
	        } else {
		            $numpage = 10;
		            $remarks = Remark::find()->limit($numpage)->all();
		            return $this->render('index', [
		            //'searchModel' => $searchModel,
		            //'dataProvider' => $dataProvider,
		            'remarks' => $remarks,
		        ]);
	        }

   		 }
     
        
    }

    public function init()
    {
        parent::init();
    }

    public function run()
    {
         // Register AssetBundle
        return $this->render('remarkComponentView');
    }
}
?>