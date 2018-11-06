<?php

use yii\db\Migration;

/**
 * Class m181031_130936_new_remarks
 */
class m181031_130936_new_remarks extends Migration
{
    public function safeUp()
    {        
		$this->dropColumn("{{%remark}}", 'remark_type');
        $this->dropColumn("{{%remark}}", 'project_id');
        $this->dropForeignKey('RemarkFolder', "{{%remark}}", 'folder_id');
        $this->dropColumn("{{%remark}}", 'folder_id');
		
        $this->addColumn("{{%remark}}", 'last_updated', $this->datetime() );
		$this->addColumn("{{%remark}}", 'deleted', $this->integer(11)->after('cid') );
        $this->addColumn("{{%remark}}", 'user_id', $this->integer(11)->after('text') );
        $this->addForeignKey('AuthorUser', "{{%remark}}", 'user_id', "{{%user}}", 'id','CASCADE','CASCADE');
        $this->alterColumn('{{%remark}}', 'remark_date', $this->timestamp('CURRENT_TIMESTAMP') );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181031_130936_new_remarks cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181031_130936_new_remarks cannot be reverted.\n";

        return false;
    }
    */
}
