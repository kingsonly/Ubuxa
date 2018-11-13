<?php

use yii\db\Migration;

/**
 * Class m181111_104944_add_missing_columns_to_new_compoenent
 */
class m181111_104944_add_missing_columns_to_new_component extends Migration
{
	
	/***
	 *  a suffix to add to database name (Yii Application Component ID) for  different (special) migration controllers
	 *  to determine the context of the migration. (really just for test = _test suffix)
	 */
	public $db_suffix = '';
	
	/***
	 *  {@inheritdoc}
	 */
	public function init()
    {
		//if changing the database connection, the next 3 lines need to be uncommented. Works with SpecialMigration controller only.
        //$this->db = [INSERT THE COMPONENT ID FOR THE DB YOU WANT] . $this->db_suffix; . 
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		//alter existing table for component_template_attribute
		$this->addColumn( '{{%component_template_attribute}}', 'deleted', $this->boolean()->after('sort_order') );
		$this->addColumn( '{{%component_template_attribute}}', 'last_updated', $this->timestamp()->after('sort_order') );
		$this->addColumn( '{{%component_template_attribute}}', 'created_at', $this->timestamp()->after('sort_order') );
		
		//alter existing table for component_attribute
		$this->addColumn( '{{%component_attribute}}', 'deleted', $this->boolean()->after('value_id') );
		$this->addColumn( '{{%component_attribute}}', 'last_updated', $this->timestamp()->after('value_id') );
		$this->addColumn( '{{%component_attribute}}', 'created_at', $this->timestamp()->after('value_id') );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181111_104944_add_missing_columns_to_new_compoenent should not be reverted. Reverting for development.\n";

		$this->dropColumn("{{%component_attribute}}", 'created_at');
		$this->dropColumn("{{%component_attribute}}", 'last_updated');
		$this->dropColumn("{{%component_attribute}}", 'deleted');
		
		$this->dropColumn("{{%component_template_attribute}}", 'created_at');
		$this->dropColumn("{{%component_template_attribute}}", 'last_updated');
		$this->dropColumn("{{%component_template_attribute}}", 'deleted');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181111_104944_add_missing_columns_to_new_compoenent cannot be reverted.\n";

        return false;
    }
    */
}
