<?php
namespace boffins_vendor\classes;

use Yii;
use yii\web\Controller;
use app\models\UserDb;
use app\models\Role;
use app\models\AccessPermission;
use app\models\ControllerBaseRoute;
use yii\web\ForbiddenHttpException;


class BoffinsBaseController extends Controller
{ 

	public function beforeAction($action)
	{
		$controlledActions = AccessPermission::allActions();
		$views = [
				'index', 
				'invoiceview', 
				'invoicelistview', 
				'folderview',
				'projectlistview', 
				'projectview', 
				'orderlistview', 
				'orderview',
				'paymentlistview',
				'paymentview',
				'correspondencelistview',
				'correspondenceview',
				'rpoview',
				'rpolistview',
				'Receivedpurchaseorder'
				];
		$actionName = in_array($action->id, $views) ? 'view' : $action->id;
		if ( !in_array($actionName, $controlledActions) ) {
			return true;
		}
		$controllerName = ucfirst($action->controller->id);
		Yii::trace("Running $actionName:$controllerName");
		if (parent::beforeAction($action)) {
			if (Yii::$app->user->can("$actionName:$controllerName")) {
				return true;
			}
		}
		throw new ForbiddenHttpException(Yii::t('yii', "This page does not exist or you do not have access $actionName:$controllerName"));
		$this->_view = 'mobile';
		return false; 
		
	}
	
	public function render($view, $params = [])
    {
		
        $content = $this->getView()->render($view, $params, $this);
        return $this->renderContent($content);
    }
	
	
	

}
