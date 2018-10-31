<?php

use yii\db\Migration;

/**
 * Class m181031_092316_task_label
 */
class m181031_092316_task_label extends Migration
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
        $this->createTable("{{%task_label}}", [
                                        'task_id' => $this->integer(11)->comment('Task'),
                                        'label_id' =>    $this->integer(11)->comment('Label name'),
        ]);

        $this->createTable("{{%label}}", [
                                        'id' => $this->primaryKey(11),
                                        'name' => $this->string(50)->comment('Task label'),
        ]);

        

        $this->addForeignKey(
            'TaskId',
            "{{%task_label}}",
            'task_id',
            "{{%task}}",
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'LabelId',
            "{{%task_label}}",
            'label_id',
            "{{%label}}",
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181031_092316_task_label cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181031_092316_task_label cannot be reverted.\n";

        return false;
    }
    */
}
