<?php

namespace console\migrations;

use yii\db\Migration;

/**
 * Class M180922064835Add_foder_image
 */
class M180922064835Add_foder_image extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->addColumn('{{%folder}}', 'folder_image', $this->string()->after('description') );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "M180922064835 Add_foder_image should be reverted. Reverting for development only.\n";
		$this->dropColumn('{{%folder}}', 'folder_image');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M180922064835Add_foder_image cannot be reverted.\n";

        return false;
    }
    */
}
