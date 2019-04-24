<?php
namespace boffins_vendor\access;

use Yii;
use yii\base\BaseObject;
use frontend\models\Request;
use boffins_vendor\classes\GlobalComponent;
/*
use frontend\models\Role;
use frontend\models\AccessPermission;
use frontend\models\ControllerBaseRoute;*/

/***
 *  This is a class that handles events for the Application instance 
 */
class ApplicationEventsHandler extends BaseObject
{
	/**
	 *  @brief This is a handler for the Applicaton event 'beforeRequest'
	 *  
	 *  @return void
	 *  
	 *  @details Tasks are 
	 *  Create a request object 
	 *  generate a unique id for the request 
	 *  include the session id. 
	 *  
	 *  This tracking helps observe user activity 
	 *  and is used critically, by activity stream in order to track the objects that are modified in a request. 
	 *  
	 *  the request id is saved to params so that it is globablly accessible and the request object can be recreated on the fly 
	 *  static because the class rarely has instances. 
	 */
	public static function handleBeforeRequest() 
	{
		$msg = isset( Yii::$app->request ) ? "with a request object" : "WITHOUT a request object";
		Yii::trace("Handling the before request event $msg", __METHOD__);
		$request = new Request;
		Yii::trace("The Request ID: {$request->id}", __METHOD__); //- it works 
		Yii::$app->params['request_id'] = $request->id;
		$request->save();
	}
	
	/**
	 *  @brief A handler to manage the Application event afterRequest. 
	 *  
	 *  @return void
	 *  
	 *  @details Tasks are:
	 *  recreate the request AR
	 *  tidies up the object - i.e. adds the rest of the columns 
	 *  this has to be a static function as this object rarely, if ever, is instantiated. 
	 */
	public static function handleAfterRequest()
	{
		$request = Request::findOne(Yii::$app->params['request_id']);
		Yii::trace("The Request ID: {$request->id}", __METHOD__); //- it works
		$request->complete();
		$request->save();
		Yii::trace("The Session ID: " . Yii::$app->session->id, __METHOD__);
	}
}