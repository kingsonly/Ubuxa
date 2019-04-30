<?php
namespace boffins_vendor\classes;

use Yii;
use yii\web\Controller;
use frontend\models\UserDb;
use frontend\models\Role;
use frontend\models\AccessPermission;
use frontend\models\ControllerBaseRoute;
use yii\web\ForbiddenHttpException;


class BoffinsBaseController extends Controller
{ 

	public function beforeAction($action)
	{
		//return true;
		if ( $this->_userPermmitted($action) && parent::beforeAction($action) ) {
			Yii::trace("This user is permitted this action. Performing necessary procedures before action.", __METHOD__);
			return true;
		}
		
		//$this->_view = 'mobile';
		throw new ForbiddenHttpException(Yii::t('yii', "This page does not exist or you do not have access $actionName:$controllerName"));
	}
	
	/**
	 *  @inheritdoc. 
	 *  currently no new changes to parent function???
	 */
	public function render($view, $params = [])
    {
		return parent::render($view, $params);
    }
	
	/**
	 *  @brief checks if a user can perform a certain action 
	 *  and return trus if so. 
	 *  
	 *  @param [in] $action. The action object to check for. Use $action->id to access the id
	 *  @return boolean
	 *  
	 *  @details More details
	 */
	private function _userPermmitted($action) 
	{
		$evaluation = false;
		$controlledActions = AccessPermission::allActions();
		$views = [
				'index', 
				'folderview',
				/*'invoiceview', 
				'invoicelistview', 
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
				THESE VIEWS HAVE BEEN DEPRECATED*/
				];
		$actionName = in_array($action->id, $views) ? 'view' : $action->id;
		if ( !in_array($actionName, $controlledActions) ) {
			$evaluation = true; //permit all actions that are not controlled. Hmn... Is this the desired result?
		}
		$controllerName = ucfirst($action->controller->id);
		Yii::trace("Evaluating $actionName:$controllerName");
		if (Yii::$app->user->can("$actionName:$controllerName")) { //Hmn!
			$evaluation = true;
		}
		return $evaluation; 
	}
	
	
	

}
