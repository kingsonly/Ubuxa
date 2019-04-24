<?php

use yii\db\Migration;

/**
 * Class m190222_041527_add_activity_subscriptions_table
 */
class m190222_041527_add_activity_subscriptions_table extends Migration
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
		//create a table for subscriptions 
		$this->createTable('{{%subscription}}', [
            'id' => $this->char(255)->notNull(),
            'user_id' => $this->integer(11),
            'object_id' => $this->integer(11),
			'object_class_id' => $this->integer(11),
			'action_id' => $this->char(255)->comment("Should really map to a class of actions such as folderview mapped to view"),
        ]);
		
		//create a table for activity object classes 
		$this->createTable('{{%activity_object_class}}', [
            'id' => $this->primaryKey(11),
            'class_name' => $this->char(255)->comment("The full class name - including namespace"),
			'controller_name' => $this->char(255)->comment("The full class name - including namespace of the controller"),
        ]);
		
		//insert some basic data to activity_object_class
		$this->batchInsert("{{%activity_object_class}}", ['class_name', 'controller_name'], [
													['frontend\models\Folder', 'frontend\controllers\FolderController'],
													['frontend\models\Task', 'frontend\controllers\TaskController'],
													['frontend\models\Remark', 'frontend\controllers\RemarkController'],
													['frontend\models\EDocument', 'frontend\controllers\EdocumentController'],
        ]);
		
		//create a table for activity messages 
		$this->createTable('{{%activity_message}}', [
            'id' => $this->char(64),
            'activity_id' => $this->char(64),
            'message' => $this->char(255),
			'user_id' => $this->integer(11),
        ]);
		
		//modifications for the subscribtion table 
        $this->addPrimaryKey('pk-id', '{{%subscription}}', 'id');
										
		//create an index on user_id in subscription
        $this->createIndex(
            'idx-subscription-user_id',
            "{{%subscription}}",
            'user_id'
        );
				
		//add foreign key to table user
        $this->addForeignKey(
            'Subscriber',
            "{{%subscription}}",
            'user_id',
            "{{%user}}",
            'id',
            'CASCADE'
        );
		
		//create an index on object_id in subscription
        $this->createIndex(
            'idx-subscription-object_id',
            "{{%subscription}}",
            'object_id'
        );
		
		//create an index on object_class_id in subscription
        $this->createIndex(
            'idx-subscription-object_class_id',
            "{{%subscription}}",
            'object_class_id'
        );
		
		//add foreign key to table activity_object_class
        $this->addForeignKey(
            'ActivityObjectClass',
            "{{%subscription}}",
            'object_class_id',
            "{{%activity_object_class}}",
            'id',
            'CASCADE'
        );
		
		
		//modifications for the activity_message table
        $this->addPrimaryKey('pk-id', '{{%activity_message}}', 'id');
		
		//create an index on user_id in activity_message
        $this->createIndex(
            'idx-activity_message-user_id',
            "{{%activity_message}}",
            'user_id'
        );
				
		//add foreign key to table user from activity_message
        $this->addForeignKey(
            'MessageRecipient',
            "{{%activity_message}}",
            'user_id',
            "{{%user}}",
            'id',
            'CASCADE'
        );
		
		//create an index on activity_id in activity_message
        $this->createIndex(
            'idx-activity_message-activity_id',
            "{{%activity_message}}",
            'activity_id'
        );
				
		//add foreign key to table user
        $this->addForeignKey(
            'ActivityInitiator',
            "{{%activity_message}}",
            'activity_id',
            "{{%activity}}",
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190222_041527_add_activity_subscriptions_table should not be reverted. Reverting for development only.\n";
		
		$this->dropForeignKey('ActivityInitiator', "{{%activity_message}}");
		$this->dropForeignKey('MessageRecipient', "{{%activity_message}}");
		$this->dropForeignKey('ActivityObjectClass', "{{%subscription}}");
		$this->dropForeignKey('Subscriber', "{{%subscription}}");
		$this->dropTable("{{%activity_message}}");
		$this->dropTable("{{%activity_object_class}}");
		$this->dropTable("{{%subscription}}");

        //return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190222_041527_add_activity_subscriptions_table cannot be reverted.\n";

        return false;
    }
    */
}
