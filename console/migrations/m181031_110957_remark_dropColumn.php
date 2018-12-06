<?php

use yii\db\Migration;

/**
 * Class m181031_110957_remark_dropColumn
 */
class m181031_110957_remark_dropColumn extends Migration
{
	
	/***
	 *  a suffix to add to database name (Yii Application Component ID) for  different (special) migration controllers
	 *  to determine the context of the migration. (really just for test = _test suffix)
	 */
	//public $db_suffix = '';
	
	/***
	 *  {@inheritdoc}
	 */
	/*public function init()
    {
        $this->db = $this->db . $this->db_suffix; . 
        parent::init();
    }*/

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("{{%remark}}", 'deleted', $this->integer(11)->defaultValue(0)->after('text') );
        $this->addColumn("{{%remark}}", 'last_updated', $this->integer(11)->defaultValue('0')->after('text') );
        $this->addColumn("{{%remark}}", 'user_id', $this->integer(11)->defaultValue(0)->after('text') );
        $this->dropColumn("{{%remark}}", 'remark_type');
        $this->dropColumn("{{%remark}}", 'project_id');
        $this->dropForeignKey('RemarkFolder',"{{%remark}}",'folder_id');
        $this->dropColumn("{{%remark}}", 'folder_id');
		
		// creates index for user_id
        $this->createIndex(
            'idx-remark-user_id',
            "{{%remark}}",
            'user_id'
        );
		
		// add remark table foreign key to table `user`
        $this->addForeignKey(
            'RemarkAuthor',
            "{{%remark}}",
            'user_id',
            "{{%user}}",
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181031_110957_remark_dropColumn cannot be reverted. \n";

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181031_110957_remark_dropColumn cannot be reverted.\n";

        return false;
    }
    */
}
