<?php

use yii\db\Migration;

/**
 * Class m190210_082637_add_table_request
 */
class m190210_082637_add_table_request extends Migration
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
        //$this->db = '[INSERT THE COMPONENT ID FOR THE DB YOU WANT]' . $this->db_suffix; 
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		//create a request table. 
		$this->createTable('{{%request}}', [
            'id' => $this->string(64)->comment("A request id. Unique identifier"),
            'session_id' => $this->char(64)->comment("Foreign table to session table"),
			'user_id' => $this->integer(11)->comment("A foreign table to the user table"),
			'is_ajax' => $this->boolean()->comment("Tiny int to indicate if this request was Ajax"),
			'is_console' => $this->boolean()->comment("Tiny int to indicate if this request was a console request"),
			'method' => $this->string(20)->comment("Correlates to a constand which indicates what the request method is"),
			'url' => $this->string(1000)->comment('URL requested by the user. Not up to 1000 characters '),
			'user_agent' => $this->string(1000)->comment('URL requested by the user. Not up to 1000 characters '),
			'start_time' => $this->timestamp()->comment('The time the request starts (rough estimate)'),
			'end_time' => $this->timestamp()->comment('The time the request ends (rough estimate)'),
			//in the future, we should include a data field to track the data sent in a request.
        ]);
		
		$this->addPrimaryKey('pk-id', '{{%request}}', 'id');
		
		// creates request table index for session_id
        $this->createIndex(
            'idx-request-session_id',
            "{{%request}}",
            'session_id'
        );
		
		// add request table foreign key to table `session` for Session
        /*$this->addForeignKey(
            'Sesion',
            "{{%request}}",
            'session_id',
            "{{%session}}",
            'id',
            'CASCADE'
        ); REMOVING THIS BECAUSE SETTING A FOREIGN KEY ON THIS KEY MEANS THE PRIMARY KEY CAN'T BE UPDATED??? */
		
		// creates request table index for user_id
        $this->createIndex(
            'idx-request-user_id',
            "{{%request}}",
            'user_id'
        );
		
		// add request table foreign key to table `user` for RequestingUser
        $this->addForeignKey(
            'RequestingUser',
            "{{%request}}",
            'user_id',
            "{{%user}}",
            'id',
            'CASCADE'
        );
		
		//add foreign key to table user
        $this->addForeignKey(
            'ActivitiesRequest',
            "{{%activity}}",
            'request_id',
            "{{%request}}",
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190210_082637_add_table_request should not be reverted. Reverting for development only.\n";
		
		$this->dropForeignKey('RequestingUser', "{{%request}}");
		$this->dropIndex('idx-request-user_id', "{{%request}}");
		//$this->dropForeignKey('Sesion', "{{%request}}");
		$this->dropIndex('idx-request-session_id', "{{%request}}");
		$this->dropForeignKey('ActivitiesRequest', "{{%activity}}");
		$this->dropTable("{{%request}}");


        //return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190210_082637_add_table_request cannot be reverted.\n";

        return false;
    }
    */
}
