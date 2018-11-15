<?php

use yii\db\Migration;

/**
 * Class m181031_121458_alter_remark_timestamp
 */
class m181031_121458_alter_remark_timestamp extends Migration
{
	
	
    public function safeUp()
    {
        $this->alterColumn('{{%remark}}', 'remark_date', $this->timestamp('CURRENT_TIMESTAMP'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181031_121458_alter_remark_timestamp cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181031_121458_alter_remark_timestamp cannot be reverted.\n";

        return false;
    }
    */
}
