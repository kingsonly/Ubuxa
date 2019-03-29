<?php

use yii\db\Migration;

/**
 * Class m190205_074221_calendar_check_status
 */
class m190205_074221_calendar_check_status extends Migration
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
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //create calendar check table.
        $this->createTable('{{%calendar}}', [
            'id' => $this->primaryKey(11),
            'last_id' => $this->integer(11)->comment("foreign key to task table"),
            'type' => $this->string(255)->comment("event or task"),
            'user_id' => $this->integer(11)->defaultValue(null)->comment("foreign key to user table"),
            'deleted' => $this->integer(11)->comment("deleted event or not"),
            'last_updated' => $this->timestamp()->comment("foreign key to user table"),
            'cid' => $this->integer(11)->comment("customer id")
        ]);


        //create calendar check table.
        $this->createTable('{{%calendar_check_status}}', [
            'id' => $this->primaryKey(11),
            'status' => $this->integer(11)->defaultValue(0)->comment("A status to for either google calendar or ubuxa calendar"),
            'user_id' => $this->integer(11)->comment("foreign key to user table"),
        ]);

        //create calendar reminder table.
        $this->createTable('{{%calendar_reminder}}', [
            'id' => $this->primaryKey(11),
            'reminder_id' => $this->integer(11)->comment("foreign key to reminder table"),
            'user_id' => $this->integer(11)->comment("foreign key to user table"),
        ]);

         //create google calendar id table.
        $this->createTable('{{%google_calendar_id}}', [
            'id' => $this->primaryKey(11),
            'calendar_id' => $this->integer(11)->comment("A column for google calendar IDs"),
            'user_id' => $this->integer(11)->comment("foreign key to user table"),
        ]);

        // creates calendar_Reminder table index for reminder_id
        $this->createIndex(
            'idx-calendar_reminder-reminder_id',
            "{{%calendar_reminder}}",
            'reminder_id'
        );

        $this->createIndex(
            'idx-calendar_reminder-user_id',
            "{{%calendar_reminder}}",
            'user_id'
        );

        // add calendar_reminder table foreign key to table `reminder`
        $this->addForeignKey(
            'CalendarReminder',
            "{{%calendar_reminder}}",
            'reminder_id',
            "{{%reminder}}",
            'id',
            'CASCADE'
        );

        // add calendar_reminder table foreign key to table `user`
        $this->addForeignKey(
            'getUser',
            "{{%calendar_reminder}}",
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
        echo "m190205_074221_calendar_check_status should not be reverted. Reverting for development only.\n";

        $this->dropForeignKey('CalendarReminder', "{{%calendar_reminder}}");
        $this->dropForeignKey('getUser', "{{%calendar_reminder}}");
        $this->dropIndex('idx-calendar_reminder-reminder_id', "{{%calendar_reminder}}");
        $this->dropIndex('idx-calendar_reminder-user_id', "{{%calendar_reminder}}");
        $this->dropTable("{{%calendar_check_status}}");
        $this->dropTable("{{%calendar_reminder}}");
        $this->dropTable("{{%google_calendar_id}}");
        $this->dropTable("{{%calendar}}");

        //return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190205_074221_calendar_check_status cannot be reverted.\n";

        return false;
    }
    */
}
