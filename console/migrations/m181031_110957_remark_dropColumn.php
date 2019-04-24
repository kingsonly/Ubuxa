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
	 *  this variable is changed from the controller/config - it is usually not necessary to change it here. 
	 */
	public $db_suffix = '';
	
	/***
	 *  {@inheritdoc}
	 */
	public function init()
    {
		//if changing the database connection, the next line needs to be uncommented. Works with SpecialMigration controller only.
        //$this->db = '[INSERT THE COMPONENT ID FOR THE DB YOU WANT]' . $this->db_suffix; 
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("{{%remark}}", 'deleted', $this->boolean()->after('text') );
        $this->addColumn("{{%remark}}", 'last_updated', $this->timestamp()->after('text') );
        $this->addColumn("{{%remark}}", 'user_id', $this->integer(11)->defaultValue(0)->after('text') );
        $this->dropColumn("{{%remark}}", 'remark_type');
        $this->dropColumn("{{%remark}}", 'project_id');
        $this->dropForeignKey('RemarkFolder', "{{%remark}}");
        //$this->dropIndex('folder_id', "{{%remark}}"); 
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
        echo "m181031_110957_remark_dropColumn cannot be reverted. Reverting for development only \n";
		$this->dropColumn("{{%remark}}", 'deleted');
		$this->dropColumn("{{%remark}}", 'last_updated');
		
		//$this->dropIndex('idx-remark-user_id', "{{%remark}}");
		$this->dropForeignKey('RemarkAuthor', "{{%remark}}");
		
		$this->dropColumn("{{%remark}}", 'user_id');
        $this->addColumn("{{%remark}}", 'remark_type', $this->string(255) );
        $this->addColumn("{{%remark}}", 'project_id', $this->integer(11) );
        $this->addColumn("{{%remark}}", 'folder_id', $this->integer(11) );
		
		// creates index for folder_id
        $this->createIndex(
            'folder_id',
            "{{%remark}}",
            'folder_id'
        );
		
		//add remark table foreign key to table `user`
        $this->addForeignKey(
            'RemarkFolder',
            "{{%remark}}",
            'folder_id',
            "{{%folder}}",
            'id',
            'CASCADE'
        );
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
