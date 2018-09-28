<?php

namespace console\migrations;

use yii\db\Migration;

/**
 * Class M180922061905Add_private_column
 */
class M180922061905Add_private_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->addColumn('{{%folder}}', 'private', $this->boolean()->defaultValue(0)->after('description') );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "M180922061905 Private is a standard feature. This column should not be reverted. Reverting for development only.\n";
		$this->dropColumn('{{%folder}}', 'private');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M180922061905Add_private_column cannot be reverted.\n";

        return false;
    }
    */
}
