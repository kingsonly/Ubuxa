<?php

use yii\db\Migration;

/**
 * Class m181123_163209_customer_has_admin
 */
class m181123_163209_customer_has_admin extends Migration
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
        //$this->db = [INSERT THE COMPONENT ID FOR THE DB YOU WANT] . $this->db_suffix; 
        $this->db = 'db_tenant' . $this->db_suffix; 
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn( '{{%customer}}', 'has_admin', $this->integer(11)->defaultValue(0)->after('account_number'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181123_163209_customer_has_admin cannot be reverted.\n";
        $this->dropColumn("{{%customer}}", 'has_admin');
        //return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181123_163209_customer_has_admin cannot be reverted.\n";

        return false;
    }
    */
}
