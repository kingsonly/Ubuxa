<?php

use yii\db\Migration;

/**
 * Class m181121_035814_Add_password_reset_token
 */
class m181121_035814_Add_password_reset_token extends Migration
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
        $this->addColumn('{{%user}}', 'password_reset_token', $this->string(255)->after('password') );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181121_035814_Add_password_reset_token should not be reverted. Reverting for development only.\n";

		$this->dropColumn("{{%user}}", 'password_reset_token');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181121_035814_Add_password_reset_token cannot be reverted.\n";

        return false;
    }
    */
}
