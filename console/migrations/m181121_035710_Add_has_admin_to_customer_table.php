<?php

use yii\db\Migration;

/**
 * Class m181121_035710_Add_has_admin_to_customer_table
 */
class m181121_035710_Add_has_admin_to_customer_table extends Migration
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
        $this->db = 'db_tenant' . $this->db_suffix; 
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%customer}}', 'has_admin', $this->integer(11)->after('account_number')->defaultValue(0) );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181121_035710_Add_has_admin_to_customer_table should not be reverted. Reverting for development only.\n";

		$this->dropColumn("{{%customer}}", 'has_admin');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181121_035710_Add_has_admin_to_customer_table cannot be reverted.\n";

        return false;
    }
    */
}
