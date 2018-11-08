<?php

use yii\db\Migration;

/**
 * Class m181031_113427_person_id
 */
class m181031_113427_person_id extends Migration
{
	
	
    public function safeUp()
    {
        $this->addColumn("{{%remark}}", 'person_id', $this->integer(11)->defaultValue(0)->after('text') );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181031_113427_person_id cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181031_113427_person_id cannot be reverted.\n";

        return false;
    }
    */
}
