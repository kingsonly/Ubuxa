<?php

use yii\db\Migration;

/**
 * Class m190207_075007_alter_task_group_table
 */
class m190207_075007_alter_task_group_table extends Migration
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
        $this->addColumn( '{{%task_group}}', 'remove_after_drop_status', $this->integer(11)->defaultValue(0)->after('task_child_id') );
        $this->addColumn( '{{%task_group}}', 'drop_task_status', $this->integer(11)->defaultValue(0)->after('remove_after_drop_status') );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190207_075007_alter_task_group_table should not be reverted. Reverting for development only.\n";
        $this->dropColumn('task-remove_after_drop_status', "{{%task_group}}");
        $this->dropColumn('task-drop_task_status', "{{%task_group}}");

        //return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190207_075007_alter_task_group_table cannot be reverted.\n";

        return false;
    }
    */
}
