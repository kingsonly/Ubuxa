<?php

use yii\db\Migration;

/**
 * Class m190111_074225_create_task_goal
 */
class m190111_074225_create_task_goal extends Migration
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
		//create task_group table. Self junction table lising all groups and all tasks within the group. 
		$this->createTable('{{%task_group}}', [
            'task_group_id' => $this->integer(11)->comment("A task item which is also a task group"),
			'task_child_id' => $this->integer(11)->comment("A task item which is also a child task of a task group"),
        ]);
		
		// creates task_group table index for task_group_id
        $this->createIndex(
            'idx-task_group-task_group_id',
            "{{%task_group}}",
            'task_group_id'
        );
		
		// add task_group table foreign key to table `task` for TaskGroup
        $this->addForeignKey(
            'TaskGroup',
            "{{%task_group}}",
            'task_group_id',
            "{{%task}}",
            'id',
            'CASCADE'
        );
		
		// add task_group table foreign key to table `task` for TaskChild
        $this->addForeignKey(
            'TaskChild',
            "{{%task_group}}",
            'task_child_id',
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
        echo "m190111_074225_create_task_goal should not be reverted. Reverting for development only.\n";
		
		$this->dropForeignKey('TaskChild', "{{%task_group}}");
		$this->dropForeignKey('TaskGroup', "{{%task_group}}");
		$this->dropIndex('idx-task_group-task_group_id', "{{%task_group}}");
		$this->dropTable("{{%task_group}}");

        //return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190111_074225_create_task_goal cannot be reverted.\n";

        return false;
    }
    */
}