<?php

use yii\db\Migration;

/**
 * Class m181031_114558_new_remark
 */
class m181031_114558_new_remark extends Migration
{
	
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("{{%remark}}", 'deleted', $this->boolean()->after('text') );
        $this->addColumn("{{%remark}}", 'last_updated', $this->timestamp('CURRENT_TIMESTAMP')->after('text') );
        $this->addColumn("{{%remark}}", 'user_id', $this->integer(11)->defaultValue(0)->after('id') );
        $this->dropColumn("{{%remark}}", 'remark_type');
        $this->dropColumn("{{%remark}}", 'project_id');
        $this->dropForeignKey('RemarkFolder',"{{%remark}}",'folder_id');
        $this->dropColumn("{{%remark}}", 'folder_id');
        $this->alterColumn('{{%remark}}', 'remark_date', $this->timestamp('CURRENT_TIMESTAMP') );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181031_114558_new_remark cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181031_114558_new_remark cannot be reverted.\n";

        return false;
    }
    */
}
