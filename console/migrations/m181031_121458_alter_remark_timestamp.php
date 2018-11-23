<?php

use yii\db\Migration;

/**
 * Class m181031_121458_alter_remark_timestamp
 */
class m181031_121458_alter_remark_timestamp extends Migration
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
	
    public function safeUp()
    {
        $this->alterColumn('{{%remark}}', 'remark_date', $this->timestamp('CURRENT_TIMESTAMP'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181031_121458_alter_remark_timestamp cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181031_121458_alter_remark_timestamp cannot be reverted.\n";

        return false;
    }
    */
}
