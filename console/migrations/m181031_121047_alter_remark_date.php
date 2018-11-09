<?php

use yii\db\Migration;

/**
 * Class m181031_121047_alter_remark_date
 */
class m181031_121047_alter_remark_date extends Migration
{
	
	
    public function safeUp()
    {
        $this->alterColumn('{{%remark}}', 'remark_date', 'timestamp');//timestamp new_data_type
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181031_121047_alter_remark_date cannot be reverted.\n";
        $this->alterColumn('{{%remark}}', 'remark_date', 'datetime');//timestamp new_data_type

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181031_121047_alter_remark_date cannot be reverted.\n";

        return false;
    }
    */
}
