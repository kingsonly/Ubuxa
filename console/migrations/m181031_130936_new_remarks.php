<?php

use yii\db\Migration;

/**
 * Class m181031_130936_new_remarks
 */
class m181031_130936_new_remarks extends Migration
{
	
	
    public function safeUp()
    {
        $this->addColumn("{{%remark}}", 'deleted', $this->integer(11)->after('cid') );
        $this->addColumn("{{%remark}}", 'last_updated', $this->datetime()->after('deleted') );
        $this->addColumn("{{%remark}}", 'person_id', $this->integer(11)->defaultValue(0)->after('text') );
        $this->dropColumn("{{%remark}}", 'remark_type');
        $this->dropColumn("{{%remark}}", 'project_id');
        $this->dropForeignKey('RemarkFolder',"{{%remark}}",'folder_id');
        $this->addForeignKey('person name',"{{%remark}}",'person_id',"{{%person}}",'id','CASCADE','CASCADE');
        $this->dropColumn("{{%remark}}", 'folder_id');
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
