<?php

use yii\db\Migration;

/**
 * Class m190304_121817_edocument_owner
 */
class m190304_121817_edocument_owner extends Migration
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
        //$this->db = [INSERT THE COMPONENT ID FOR THE DB YOU WANT] . $this->db_suffix; 
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%e_document}}', 'owner_id', $this->integer(11)->defaultValue(NULL)->after('file_location') );

        $this->addForeignKey(
            'Owner',
            "{{%e_document}}",
            'owner_id',
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
        echo "m190304_121817_edocument_owner should not be reverted. Reverting for development only.\n";
		$this->dropForeignKey('Owner', "{{%e_document}}");
		$this->dropColumn("{{%e_document}}", 'owner_id');
        //return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190304_121817_edocument_owner cannot be reverted.\n";

        return false;
    }
    */
}
