<?php

namespace console\migrations;

use yii\db\Migration;

/**
 * Class M181015105701Add_remark_parent
 */
class M181015105701Add_remark_parent extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->addColumn("{{%remark}}", 'parent_id', $this->integer(11)->defaultValue(0)->after('id') );
		//drop folder id and project id in the future 
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "M181015105701Add_remark_parent should not be reverted.\n";
		$this->dropColumn("{{%remark}}", 'parent_id');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M181015105701Add_remark_parent cannot be reverted.\n";

        return false;
    }
    */
}
