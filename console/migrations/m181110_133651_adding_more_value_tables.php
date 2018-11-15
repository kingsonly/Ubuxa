<?php

use yii\db\Migration;

/**
 * Class m181110_133651_adding_more_value_tables
 */
class m181110_133651_adding_more_value_tables extends Migration
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
		// create a value table to store lines of code 
		$this->createTable("{{%value_code_string}}", [
													'id' => $this->primaryKey(11),
													'value' => $this->string()->comment("String. Lines of code. For addons."),
													]);
		
		// create a value to store booleans
		$this->createTable("{{%value_boolean}}", [
													'id' => $this->primaryKey(11),
													'value' => $this->boolean()->comment("To store boolean values."),
													]);
		
		//create an index on value in value_code_string
        $this->createIndex(
            'idx-value_code_string-value',
            "{{%value_code_string}}",
            'value'
        );
		
		//create an index on value in value_boolean
        $this->createIndex(
            'idx-value_boolean-value',
            "{{%value_boolean}}",
            'value'
        );
		
		$this->batchInsert("{{%component_attribute_type}}", ['name', 'type'], [
													['Bool', 'boolean'],
													['Code', 'code_string'],
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181110_133651_adding_more_value_tables should not be reverted. Reverting for development only.\n";
		
		$this->dropIndex('idx-value_code_string-value', "{{%value_code_string}}");
		$this->dropIndex('idx-value_boolean-value', "{{%value_boolean}}");
		$this->dropTable("{{%value_code_string}}");
		$this->dropTable("{{%value_boolean}}");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181110_133651_adding_more_value_tables cannot be reverted.\n";

        return false;
    }
    */
}
