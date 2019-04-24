<?php

use yii\db\Migration;

/**
 * Class m190202_135244_add_activity_table
 */
class m190202_135244_add_activity_table extends Migration
{
	
	/***
	 *  a suffix to add to database name (Yii Application Component ID) for  different (special) migration controllers
	 *  to determine the context of the migration. (really just for test = _test suffix)
	 *  this variable is changed from the controller/config - it is usually not necessary to change it here. 
	 */
	public $db_suffix = '';
	
	/***
	 *  {@inheritdoc}
	 *  
	 */
	public function init()
    {
		//if changing the database connection, the next line needs to be uncommented. Works with SpecialMigration controller only.
        //$this->db = [INSERT THE COMPONENT ID FOR THE DB YOU WANT] . $this->db_suffix; 
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		//create a table for activities 
		$this->createTable('{{%activity}}', [
            'id' => $this->char(255)->notNull(),
            'session_id' => $this->char(64)->notNull()->unique()->comment('retrieve current session id'),
			'request_id'=> $this->char(64)->notNull()->unique()->comment('retrieve current request id'),
            'user_id' => $this->integer(11),
            'object_id' => $this->integer(11),
			'action_id' => $this->char(255),
            'in_progress' => $this->boolean(),
        ]);
				
        $this->addPrimaryKey('pk-id', '{{%activity}}', 'id');
						
		//create an index on session_id in activity
        $this->createIndex(
            'idx-activity-session_id',
            "{{%activity}}",
            'session_id'
        );
		
		//add foreign key to table session
        /*$this->addForeignKey(
            'ActivitySession',
            "{{%activity}}",
            'session_id',
            "{{%session}}",
            'id',
            'CASCADE'
        ); REMOVING THIS BECAUSE SETTING A FOREIGN KEY ON THIS KEY MEANS THE PRIMARY KEY CAN'T BE UPDATED??? */
		
		//create an index on user_id in activity
        $this->createIndex(
            'idx-activity-user_id',
            "{{%activity}}",
            'user_id'
        );
				
		//add foreign key to table user
        $this->addForeignKey(
            'Actor',
            "{{%activity}}",
            'user_id',
            "{{%user}}",
            'id',
            'CASCADE'
        );
		
		//create an index on user_id in activity
        $this->createIndex(
            'idx-activity-request_id',
            "{{%activity}}",
            'request_id'
        );
				
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190202_135244_add_activity_table should not be reverted. Reverting for development only.\n";
		
		$this->dropTable('{{%activity}}');

        //return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190202_135244_add_activity_table cannot be reverted.\n";

        return false;
    }
    */
}
