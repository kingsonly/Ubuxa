<?php

use yii\db\Migration;

/**
 * Class m181113_035022_basic_tracking_monitoring
 */
class m181113_035022_basic_tracking_monitoring extends Migration
{
	
	/***
	 *  a suffix to add to database name (Yii Application Component ID) for  different (special) migration controllers
	 *  to determine the context of the migration. (really just for test = _test suffix)
	 */
	public $db_suffix = '';
	
	/***
	 *  {@inheritdoc}
	 */
	public function init()
    {
		//if changing the database connection, the next 3 lines need to be uncommented. Works with SpecialMigration controller only.
        $this->db = 'db_tenant' . $this->db_suffix; 
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		// create a table for activity clicks. 
		$this->createTable("{{%activity_click}}", [
										'id' => $this->primaryKey(11),
										'button_name' => $this->string(255)->comment('just an id for the button you are tracking'), 
										'location' => $this->string()->comment('a location where the button is currently placed'), 
										'user_id' => $this->integer(11)->comment('the user who clicked this button'),
										'user_agent' => $this->string()->comment('the user agent (UA) of the device the user is using - a device string'),
										'created_at' => $this->dateTime()->comment('tracking the date this template was created'),
										'last_update' => $this->dateTime()->comment('tracking the date this template was last updated'),
										'deleted' => $this->boolean()->comment('for soft delete - DeleteUpdated does this'),
										'cid' => $this->integer(),
        ]);
		
		// create a table for activity logs. 
		$this->createTable("{{%activity_log}}", [
										'id' => $this->primaryKey(11),
										'action_name' => $this->string(255)->comment('the controller action that you are tracking'), 
										'call_location' => $this->string()->comment('a location where the action was called (an action may be called from within a unrelated view/action) '), 
										'user_agent' => $this->string()->comment('the user agent (UA) of the device the user is using - a device string'),
										'created_at' => $this->dateTime()->comment('tracking the date this template was created'),
										'last_update' => $this->dateTime()->comment('tracking the date this template was last updated'),
										'deleted' => $this->boolean()->comment('for soft delete - DeleteUpdated does this'),
										'cid' => $this->integer(),
        ]);
		
		// create a table for activity errors. 
		$this->createTable("{{%activity_errors}}", [
										'id' => $this->primaryKey(11),
										'error_string' => $this->string()->comment('the error string'), 
										'error_source' => $this->string()->comment('the source of the error - the model, controller or view and line '), 
										'error_stack' => $this->string()->comment('if possible keep a record of the full error stack'), 
										'user_agent' => $this->string()->comment('the user agent (UA) of the device the user is using - a device string'),
										'created_at' => $this->dateTime()->comment('tracking the date this template was created'),
										'last_update' => $this->dateTime()->comment('tracking the date this template was last updated'),
										'deleted' => $this->boolean()->comment('for soft delete - DeleteUpdated does this'),
										'cid' => $this->integer(),
        ]);
		
		// create a table to report a problem/ask for a feature. 
		$this->createTable("{{%user_feedback}}", [
										'id' => $this->primaryKey(11),
										'user_id' => $this->integer(11)->comment('the user id'), 
										'user_comment' => $this->string()->comment('space for the user to make a comment, ask for a feature etc'), 
										'user_agent' => $this->string()->comment('the user agent (UA) of the device the user is using - a device string'),
										'created_at' => $this->dateTime()->comment('tracking the date this template was created'),
										'last_update' => $this->dateTime()->comment('tracking the date this template was last updated'),
										'deleted' => $this->boolean()->comment('for soft delete - DeleteUpdated does this'),
										'cid' => $this->integer(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181113_035022_basic_tracking_monitoring should not be reverted. Reverting for development only. \n";
		
		$this->dropTable("{{%user_feedback}}");
		$this->dropTable("{{%activity_errors}}");
		$this->dropTable("{{%activity_log}}");
		$this->dropTable("{{%activity_click}}");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181113_035022_basic_tracking_monitoring cannot be reverted.\n";

        return false;
    }
    */
}
