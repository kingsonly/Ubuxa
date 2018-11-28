<?php

use yii\db\Migration;

/**
 * Class m181121_040108_Add_tenant_to_user_setting
 */
class m181121_040108_Add_tenant_to_user_setting extends Migration
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
		//if changing the database connection, the next line needs to be uncommented. Works with SpecialMigration controller only.
        //$this->db = [INSERT THE COMPONENT ID FOR THE DB YOU WANT] . $this->db_suffix; . 
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user_setting}}', 'cid', $this->integer()->after('date_format') );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181121_040108_Add_tenant_to_user_setting should not be reverted. Reverting for development only.\n";

		$this->dropColumn("{{%user_setting}}", 'cid');
		$this->dropColumn("{{%user_setting}}", 'tm_user_setting_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181121_040108_Add_tenant_to_user_setting cannot be reverted.\n";

        return false;
    }
    */
}
