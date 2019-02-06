<?php

use yii\db\Migration;

/**
 * Class m190205_081823_task_color
 */
class m190205_081823_task_color extends Migration
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
        //create task color table.
        $this->createTable('{{%task_color}}', [
            'id' => $this->primaryKey(11),
            'task_group_id' => $this->integer(11)->comment("foreign key to task_group table"),
            'task_color' => $this->string(255)->comment("color of each task group in RGB"),
        ]);

        //create task_group_check table.
        $this->createTable('{{%task_group_check}}', [
            'id' => $this->primaryKey(11),
            'status' => $this->integer(11)->defaultValue(0)->comment("checked or not checked"),
            'person_id' => $this->string(255)->comment("user ID"),
        ]);

        // creates task_color table index for task_group_id
        $this->createIndex(
            'idx-task_color-task_group_id',
            "{{%task_color}}",
            'task_group_id'
        );

        // add calendar_reminder table foreign key to table `user`
        $this->addForeignKey(
            'task-color',
            "{{%task_color}}",
            'task_group_id',
            "{{%task}}",
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190205_081823_task_color should not be reverted. Reverting for development only.\n";

        $this->dropForeignKey('task-color', "{{%task_color}}");
        $this->dropIndex('idx-task_color-task_group_id', "{{%task_color}}");
        $this->dropTable("{{%task_color}}");
        $this->dropTable("{{%task_group_check}}");

        //return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190205_081823_task_color cannot be reverted.\n";

        return false;
    }
    */
}
