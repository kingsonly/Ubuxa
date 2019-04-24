<?php

use yii\db\Migration;

/**
 * Class m190227_041600_add_tenant_id_to_activity
 */
class m190227_041600_add_tenant_id_to_activity extends Migration
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
		$this->addColumn( '{{%subscription}}', 'cid', $this->integer(11)->after('action_id') );
		$this->addColumn( '{{%activity_message}}', 'cid', $this->integer(11)->after('user_id') );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190227_041600_add_tenant_id_to_activity should not be reverted. Reverting for development only.\n";
        $this->dropColumn("{{%subscription}}", 'cid');
        $this->dropColumn("{{%activity_message}}", 'cid');
        //return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190227_041600_add_tenant_id_to_activity cannot be reverted.\n";

        return false;
    }
    */
}
