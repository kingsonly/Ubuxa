<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\Customer;
use backend\models\UserDb;
use backend\models\SearchModel;
use frontend\models\Task;
use frontend\models\Edocument;
//use frontend\models\Folder;
use backend\models\BackendFolder as Folder;

/**
 * Site controller
 */
class AnalyticController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
	
	public function actionIndex($start = 0,$end =0){
		$searchModel = new SearchModel();
		
		if($start == 0 and $end == 0){
			$start = date("Y-m-d", strtotime('-7 days'));
			$end = date("Y-m-d", time() + 86400);;
		}
		// fetch all forders between a time frame 
		$folders = Folder::find()->where(['between', 'last_updated', $start, $end ])->asArray()->all();
		
		// fetch all Users between a time frame 
		$users = UserDb::find()->where(['between', 'last_updated', $start, $end ])->asArray()->all();
		
		$taskModel = Task::find()->where(['between', 'create_date', $start, $end ])->asArray()->all();
		
		$edocumentModel = Edocument::find()->where(['between', 'last_updated', $start, $end ])->asArray()->all();
		/* this set of code shouold be refactored staring from  the sext line  */
		$task = [];
		$edocument = [];
		foreach($taskModel as $key => $value){
			$createDate = new \DateTime($value['create_date']);
			$strip = $createDate->format('Y-m-d');
			$value['create_date'] = $strip;
			array_push($task,$value);
		}
		
		foreach($edocumentModel as $key => $value){
			$createDate = new \DateTime($value['last_updated']);
			$strip = $createDate->format('Y-m-d');
			$value['last_updated'] = $strip;
			array_push($edocument,$value);
		}
		
		/* refactor should end at the last line above  */
		
		
		
		$getDatePeriod = [];
		$period = new \DatePeriod(
     		new \DateTime($start),
     		//new \DateTime('2019-02-26'),
     		new \DateInterval('P1D'),
			//new \DateTime('2019-08-29')
			new \DateTime($end)
		);
		
		foreach ($period as $key => $value) {
			array_push($getDatePeriod,$value->format('Y-m-d'));      
		}
		
	
		$totalFolder =  array_count_values(array_column($folders, 'last_updated')); 
		$totalUsers =  array_count_values(array_column($users, 'last_updated')); 
		$totalTask =  array_count_values(array_column($task, 'create_date')); 
		$totalEdocument =  array_count_values(array_column($edocument, 'last_updated')); 
		 
		 $folderData = $this->assingPeriodToCount($getDatePeriod,$totalFolder);
		 $userData = $this->assingPeriodToCount($getDatePeriod,$totalUsers);
		 $taskData = $this->assingPeriodToCount($getDatePeriod,$totalTask);
		 $edocumentData = $this->assingPeriodToCount($getDatePeriod,$totalEdocument);
		

		
		return $this->renderAjax('//site/chartjs', [
                'foldersData' => array_values($folderData),
                'userData' => array_values($userData),
                'taskData' => array_values($taskData),
                'edocumentData' => array_values($edocumentData),
                'label' => array_values($getDatePeriod),
                'type' => 'bar',
				'searchModel' => $searchModel,
            ]);

	}
	
	private function assingPeriodToCount($getDatePeriod,$totalData){
		$data = [];
		foreach($getDatePeriod as $key => $value){
			
			if (array_key_exists($value,$totalData)){
  				array_push($data,$totalData[$value]);
				
				
			}else{
				array_push($data,0);
  				
			}
			
		}
		return $data;
		
	}

    
}
