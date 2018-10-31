<?php

//namespace console\migrations;

use yii\db\Migration;

/**
 * Class M180919040926Remove_duplicate_address_columns
 */
class M180919040926Remove_duplicate_address_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->dropColumn('{{%address}}', 'state');
		$this->dropColumn('{{%address}}', 'country');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "M180919040926Remove_duplicate_address_columns should not be reverted. Reverting for development only.\n";
		$this->addColumn('{{%address}}', 'state', $this->string(255) );
		$this->addColumn('{{%address}}', 'country', $this->string(255) );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M180919040926Remove_duplicate_address_columns cannot be reverted.\n";

        return false;
    }
    */
}
