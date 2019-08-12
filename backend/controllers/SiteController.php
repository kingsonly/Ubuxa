<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\Customer;
use frontend\models\UserDb;
use frontend\models\Task;
use frontend\models\Edocument;
//use frontend\models\Folder;
use backend\models\BackendFolder as Folder;

/**
 * Site controller
 */
class SiteController extends Controller
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		$this->layout = 'dashboardtwo';
		
		$customers = Customer::find()->all();
		$users = UserDb::find()->all();
		$folder = Folder::find()->all();
		$task = Task::find()->all();
		$documents = Edocument::find()->all();
		
		$totalCustomers = count($customers);
		$totalUsers = count($users);
		$totalFolder = count($folder);
		$totalTasks = count($task);
		$totalDocuments = count($documents);
		
        return $this->render('index',[
			'totalCustomers' => $totalCustomers,
			'totalUsers' => $totalUsers,
			'totalFolder' => $totalFolder,
			'totalTasks' => $totalTasks,
			'totalDocuments' => $totalDocuments,
		]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
