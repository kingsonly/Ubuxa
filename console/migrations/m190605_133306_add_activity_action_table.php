<?php

use yii\db\Migration;

/**
 * Class m190605_133306_add_activity_action_table
 */
class m190605_133306_add_activity_action_table extends Migration
{
	
	/***
	 *  a suffix to add to database name (Yii Application Component ID) for  different (special) migration controllers
	 *  to determine the context of the migration. (really just for test = _test suffix)
	 *  this variable is changed from the controller/config - it is usually not necessary to change it here. 
	 */
	public $db_suffix = '';
	
	/***
	 *  {@inheritdoc}
	 */
	public function init()
    {        
		parent::init(); //init should be run by first running parent before commencing subclass initialisation 
		//if changing the database connection, the next line needs to be uncommented. Works with SpecialMigration controller only.
        //$this->db = '[INSERT THE COMPONENT ID FOR THE DB YOU WANT]' . $this->db_suffix; 
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		//create a table for activity actions 
		$this->createTable('{{%activity_action}}', [
            'id' => $this->primaryKey(11),
            'controller_name' => $this->char(255)->comment("The full class name - including namespace of the controller"),
            'action' => $this->char(255)->comment("The action id - a member of this controller"),
        ]);

        //insert some basic data to activity_action
		$this->batchInsert("{{%activity_action}}", ['controller_name', 'action'], [
            ['frontend\controllers\FolderController', 'index'],
            ['frontend\controllers\FolderController', 'view'],
            ['frontend\controllers\FolderController', 'create'],
            ['frontend\controllers\FolderController', 'update'],
            ['frontend\controllers\FolderController', 'delete'],
            ['frontend\controllers\TaskController', 'index'],
            ['frontend\controllers\TaskController', 'create'],
            ['frontend\controllers\TaskController', 'update'],
            ['frontend\controllers\TaskController', 'delete'],
            ['frontend\controllers\TaskController', 'view'],
            ['frontend\controllers\TaskController', 'dashboardcreate'],
            ['frontend\controllers\RemarkController', 'index'],
            ['frontend\controllers\RemarkController', 'create'],
            ['frontend\controllers\RemarkController', 'update'],
            ['frontend\controllers\RemarkController', 'delete'],
            ['frontend\controllers\RemarkController', 'view'],
            ['frontend\controllers\EdocumentController', 'index'],
            ['frontend\controllers\EdocumentController', 'create'],
            ['frontend\controllers\EdocumentController', 'update'],
            ['frontend\controllers\EdocumentController', 'delete'],
            ['frontend\controllers\EdocumentController', 'view'],
            ['frontend\controllers\EdocumentController', 'upload'],
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190605_133306_add_activity_action_table should not be reverted. Reverting for development only.\n";

        $this->dropTable('{{%activity_action}}');


        //return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190605_133306_add_activity_action_table cannot be reverted.\n";

        return false;
    }
    */
}
