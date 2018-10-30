<?php 
/**
 * @copyright Copyright (c) 2017 Tycol Main (By Epsolun Ltd)
 */

namespace boffins_vendor\classes;

use Yii;
use yii\console\controllers\MigrateController;


class SpecialMigration extends MigrateController 
{
	/***
	 *  a suffix to add to database name (Yii Application Component id) for special migrations
	 */
	public $db_suffix = '';
	
	/***
	 *  @inherit doc
	 */
	public function init()
    {
        //$this->db = $this->db . $this->db_suffix;
        parent::init();
    }
	
    public function beforeAction($action)
	{
		echo "Changing DB Name";
		$this->db = $this->db . $this->db_suffix;
        return parent::beforeAction($action);
	}

}
