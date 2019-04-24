<?php

//namespace console\migrations;

use yii\db\Migration;

/**
 * Class M180919034504Create_user_image
 */
class M180919034504Create_user_image extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->addColumn( '{{%user}}', 'profile_image', $this->string()->after('authKey') );
		echo "Profile Image Column Added";
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "M180919034504Create_user_image cannot be reverted. Reverting for development\n";
        $this->dropColumn("{{%user}}", 'profile_image');
        //return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M180919034504Create_user_image cannot be reverted.\n";

        return false;
    }
    */
}
