<?php

use yii\db\Migration;

/**
 * Class m181113_072211_alter_task_table
 */
class m181113_072211_alter_task_table extends Migration
{
	
	/***
	 *  a suffix to add to database name (Yii Application Component ID) for  different (special) migration controllers
	 *  to determine the context of the migration. (really just for test = _test suffix)
	 */

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%task}}', 'due_date', $this->dateTime()->defaultValue(NULL));
        $this->alterColumn('{{%task}}', 'assigned_to', $this->integer(11)->defaultValue(NULL));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181113_072211_alter_task_table cannot be reverted.\n";

        //return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181113_072211_alter_task_table cannot be reverted.\n";

        return false;
    }
    */
}
