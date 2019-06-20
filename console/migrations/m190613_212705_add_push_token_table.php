<?php

use yii\db\Migration;

/**
 * Class m190613_212705_add_push_token_table
 */
class m190613_212705_add_push_token_table extends Migration
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
        //create a table for user_device_push_token 
		$this->createTable('{{%user_device_push_token}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'push_token' => $this->string(255)->notNull()->unique(),
            'device' => $this->integer(11),
        ]);

        //add foreign key to table user
        $this->addForeignKey(
            'MobileUser',
            "{{%user_device_push_token}}",
            'user_id',
            "{{%user}}",
            'id',
            'CASCADE'
        );
        

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190613_212705_add_push_token_table should not be reverted. Reverting for development only.\n";
		$this->dropForeignKey('MobileUser', "{{%user_device_push_token}}");
		$this->dropTable("{{%user_device_push_token}}");
        //return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190613_212705_add_push_token_table cannot be reverted.\n";

        return false;
    }
    */
}
