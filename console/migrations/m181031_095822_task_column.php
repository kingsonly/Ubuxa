<?php

use yii\db\Migration;

/**
 * Class m181031_094709_task_column
 */
class m181031_095822_task_column extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%task_Assigned_User}}', 'status', $this->integer(11)->defaultValue(0)->after('assigned_date') );

        $this->addColumn('{{%task}}', 'in_progress_time', $this->dateTime()->after('due_date') );
        $this->addColumn('{{%task}}', 'completion_time', $this->dateTime()->after('in_progress_time') );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181031_094709_task_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181031_094709_task_column cannot be reverted.\n";

        return false;
    }
    */
}
