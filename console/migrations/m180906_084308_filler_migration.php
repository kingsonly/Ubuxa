<?php

namespace console\migrations;

use yii\db\Migration;

/**
 * Class m180906_084308_filler_migration
 */
class m180906_084308_filler_migration extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		echo "This is just a filler migration to ensure previous are filled properly.";
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180906_084308_filler_migration cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180906_084308_filler_migration cannot be reverted.\n";

        return false;
    }
    */
}
