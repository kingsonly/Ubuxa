<?php

use yii\db\Migration;

/**
 * Class m180829_065111_restructure_task_and_reminder
 */
class m180829_065111_restructure_task_and_reminder extends Migration
{
    /**
     * {@inheritdoc};
     */
    public function safeUp()
    {
		echo "This migration should not be applied";
		return false;
		$this->addColumn("{{%reminder}}", 'task_id', $this->integer );
		$this->createIndex(
            'idx-reminder-task_id',
            "{{%reminder}}",
            'task_id'
        );
		
        $this->addForeignKey(
            'TaskItem',
            "{{%reminder}}",
            'task_id',
            "{{%task}}",
            'id',
            'CASCADE'
        );
		
		$this->dropTable("{{%task_reminder}}");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "This migration is critical and should not be reverted. Reverting now only in order to allow flexibility. Reapply later.\n";
		
		$this->dropColumn("{{%reminder}}", 'task_id');
		
		/********* BEGIN rebuild junction table that previously existed. *****/
		$this->createTable("{{%task_reminder}}", [
										'task_id' => $this->integer(),
										'reminder_id' => $this->integer(),
										'PRIMARY KEY(task_id, reminder_id)',
        ]);
		// creates index for task_id
        $this->createIndex(
            'idx-task_reminder-task_id',
            "{{%task_reminder}}",
            'task_id'
        );

        // add foreign key for table `task`
        $this->addForeignKey(
            'ReminderTask',
            "{{%task_reminder}}",
            'task_id',
            "{{%task}}",
            'id',
            'CASCADE'
        );

        // creates index for column `reminder_id`
        $this->createIndex(
            'idx-task_reminder-reminder_id',
            "{{%task_reminder}}",
            'reminder_id'
        );

        // add foreign key for table `reminder`
        $this->addForeignKey(
            'TaskReminder',
            "{{%task_reminder}}",
            'reminder_id',
            "{{%reminder}}",
            'id',
            'CASCADE'
        );
		/********* END rebuild junction table that previously existed. *****/
		
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180829_065111_restructure_task_and_reminder cannot be reverted.\n";

        return false;
    }
    */
}
