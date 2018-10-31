<?php 
/**
 * @copyright Copyright (c) 2017 Tycol Main (By Epsolun Ltd)
 */

namespace boffins_vendor\migration;

use Yii;
use yii\console\controllers\MigrateController;
use yii\base\BaseObject;



class SpecialMigration extends MigrateController 
{
	/***
	 *  a suffix to add to database name (Yii Application Component ID) for special migrations
	 */
	public $db_suffix = '';
	
	/***
     * const name for a Migration event that is triggered before deleting a record.
     * You may set [[ModelEvent::isValid]] to be false to stop the deletion.
     */
    const EVENT_AFTER_CREATE_MIGRATION = 'afterCreateMigration';
	
	/***
	 *  @inherit doc
	 */
	public function init()
    {
        $this->db = $this->db . $this->db_suffix; //unfortunately, this is being overriden for tenant tables when db is set in code by the migration - therefore, for these situations, use a special template file. 
        parent::init();
    }
	
    /**
     *  @brief overriding parent function in order to ensure that the correct $db_suffix variable is passed into the yii/db/migrate class
     *  parent function creates a migration object of class yii/db/migrate but $db_suffix is not a standard variable 
     *  it is included through the special_migration_template.php 
     *  
     *  @param - see inherit doc ] $class full class name of the migration from your migration folder console/migrations
     *  @return the migration object of yii/db/migrate (or subclass if it is subclassed) but from your migration folder. 
     *  
     *  @details It is essential that the parent function is utilised to ensure continuity with the base code - yii core. 
     */
    protected function createMigration($class)
    {
		$migration = parent::createMigration($class);

        /** add the variable of $db_suffix */
        if ($migration instanceof BaseObject && $migration->canSetProperty('db_suffix')) {
            $migration->db_suffix = $this->db_suffix;
			$this->stdout("*##	Injecting db_suffix for this migration ", yii\helpers\Console::FG_RED);
        } 
		$migration->init();
		
        return $migration;
    }
}
