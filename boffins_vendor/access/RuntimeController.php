<?php
namespace boffins_vendor\access;

use Yii;
use yii\console\Controller;
use app\models\UserDb;
use app\models\Role;
use app\models\AccessPermission;
use app\models\ControllerBaseRoute;


class RuntimeController extends Controller
{
	public function actionInit() 
	{
		$auth = Yii::$app->authManager;
		
		//Create permissions 
		$accessPermissions = AccessPermission::find()->all();
		$controllerBaseRoutes = ControllerBaseRoute::find()->all();
		foreach ( $accessPermissions as $permissionType ) {
			foreach ( $controllerBaseRoutes as $cR ) {
				$permission = $auth->createPermission($permissionType->action . ':' . $cR->name);
				$permission->description = 'Permit ' . ucfirst($permissionType->action) . ' on ' . ucfirst($cR->name) . ' items.';
				$auth->add($permission);
				//Create all roles
				foreach ( Role::find()->all() as $roleItem ) {
					$role = $auth->createRole($roleItem->name);
					$auth->add($role);
					
					if ( Yii::$app->user->containsPermission($roleItem->access_level, $permissionType->access_value) && !$auth->hasChild($role, $permission) ) {
						$auth->addChild($role, $permission);
					}
					//switch 
				} 
			}
		}
		//Assign permisions to roles 
		//Write rules 
	}
	
	
}