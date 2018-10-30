<?php

//namespace console\migrations;

use yii\db\Migration;

/**
 * Class M181021211010New_component_structure
 */
class M181021211010New_component_structure extends Migration
{
    /**
     * {@inheritdoc}
	 * creating multiple tables for the new component structure 
	 * this uses a bit of an EAV approach to modelling the component entity 
	 * to ensure that all components of all types are accomodated. 
     */
    public function safeUp()
    {
		// create a table for ComponentTemplate. 
		$this->createTable("{{%component_template}}", [
										'id' => $this->primaryKey(11),
										'name' => $this->string(55)->comment('just a public name for the customer/user'), 
										'created_at' => $this->dateTime()->comment('tracking the date this template was created'),
										'last_update' => $this->dateTime()->comment('tracking the date this template was last updated'),
										'deleted' => $this->boolean()->comment('for soft delete - DeleteUpdated does this'),
										'cid' => $this->integer(),
        ]);
		
		// create a table for ComponentTemplateAttribute
		$this->createTable("{{%component_template_attribute}}", [
										'id' => $this->primaryKey(11),
										'component_template_id' => $this->integer(11)->comment('foreign key to component_template table'),
										'name' => $this->string(55)->comment('just a public name for the customer/user'), 
										'format' => $this->string(255)->comment('a format which this field must conform to at afterfind'), 
										'attribute_type_id' => $this->integer(11)->comment('foreign key to component_attribute_type'),
										'show_in_grid' => $this->boolean()->comment('to track if this field should have a column in grid view'),
										'sort_order' => $this->integer(2),
										'cid' => $this->integer(),
        ]);
		
		// create a table for ComponentAttributeType
		$this->createTable("{{%component_attribute_type}}", [
										'id' => $this->primaryKey(11)->comment('types may be money/amount, string, object '),
										'name' => $this->string(55)->comment('just a public name for the customer/user'),
										'type' => $this->string()->comment('must be a type: integer, varchar, decimal, classname, or blob'),
										'default_format' => $this->string(255)->comment('a default format if the user does not set one'), 
										'cid' => $this->integer()->comment('we need to discuss this as attribute types will be common to all customers'),
        ]);
		
		// create a table for behaviours (do not forget actions, relationships and events - later)
		$this->createTable("{{%component_trait}}", [
										'id' => $this->primaryKey(11),
										'name' => $this->string(55)->comment('just a name for the trait'), 
										'class_name' => $this->string(255)->comment('a classname to the trait'), 
        ]);
				
		//alter existing table for components
		$this->addColumn( '{{%component}}', 'deleted', $this->boolean(11)->after('id') );
		$this->addColumn( '{{%component}}', 'last_updated', $this->timestamp(11)->after('id') );
		$this->addColumn( '{{%component}}', 'created_at', $this->timestamp(11)->after('id') );
		$this->addColumn( '{{%component}}', 'title', $this->string(255)->after('id') );
		$this->addColumn( '{{%component}}', 'component_template_id', $this->integer(11)->after('id') );

		// create a table for ComponentInstanceAttribute. 
		$this->createTable("{{%component_attribute}}", [
										'id' => $this->primaryKey(11),
										'component_id' => $this->integer(11)->comment('foreign key to component table'),
										'component_template_attribute_id' => $this->integer(11)->comment('foreign key to component_template_attribute table'),
										'value_id' => $this->integer(11)->comment('foreign key to one of the value tables'),
										'cid' => $this->integer(),
        ]);
		
		// create a table for ComponentAttributeTrait. 
		$this->createTable("{{%component_attribute_trait}}", [
										'attribute_id' => $this->integer(11)->comment('foreign key to trait table'),
										'trait_id' => $this->integer(11)->comment('foreign key to component_template_attribute table'),
        ]);
		
		// create a junction table for linked components 
		$this->createTable("{{%component_component}}", [
													'component_id' => $this->integer(11)->comment('foreign key to component table'),
													'linked_component' => $this->integer(11)->comment('foreign key to component table'),
		]);
		
		// create a table for integer values. 
		$this->createTable("{{%value_integer}}", [
													'id' => $this->primaryKey(11),
													'value' => $this->integer(26)->comment("the actual value of the cell"),
		]);
		
		// create a table for short string values (255) max. 
		$this->createTable("{{%value_short_string}}", [
													'id' => $this->primaryKey(11),
													'value' => $this->string(255)->comment("the actual value of the cell"),
		]);
		
		// create a table for long string values above length 255 - text etc. 
		$this->createTable("{{%value_long_string}}", [
													'id' => $this->primaryKey(11)->comment('preferred table for long strings as it has an index for searching'),
													'value' => "LONGTEXT NOT NULL", //the actual value of the cell"),
		]);
		
		// create a table for amount/money values. 
		$this->createTable("{{%value_money}}", [
													'id' => $this->primaryKey(11),
													'value' => $this->decimal(16,4)->comment("the actual value of the cell"),
		]);
		
		// create a table for objects that are values - for instance a currency id can be mapped using the class and the id. 
		$this->createTable("{{%value_known_class}}", [
													'id' => $this->primaryKey(11),
													'value' => $this->string()->comment("full class name including namespace of the class"),
													'query' => $this->string()->comment("query to be applied against the class to get the instance needed"),
		]);
		
		// create a table for all other data objects not mapped above. 
		$this->createTable("{{%value_variant_object}}", [
													'id' => $this->primaryKey(11),
													'value' => "LONGBLOB NOT NULL",
													'type' => $this->string()->comment("for images and raw binaries - avoid use unless essential"),
		]);
		
		// create a table for all other strings not mapped above (json?, html? etc). 
		$this->createTable("{{%value_variant_string}}", [
													'id' => $this->primaryKey(11)->comment('table is for json, html etc dumps or serialised objects not known.'),
													'value' => "LONGTEXT NOT NULL",
													'type' => $this->string()->comment("a preferred data type to convert the value to if it is not serialised - this is not indexed"),
		]);
		
		//create an index on name in component_template
        $this->createIndex(
            'idx-component_template-name',
            "{{%component_template}}",
            'name'
        );
		
		//create an index on name in component_template_attribute
        $this->createIndex(
            'idx-component_template_attribute-name',
            "{{%component_template_attribute}}",
            'name'
        );
				
		//create an index on component_template_id in component_template_attribute
        $this->createIndex(
            'idx-component_template_attribute-component_template_id',
            "{{%component_template_attribute}}",
            'component_template_id'
        );
		
		//create an index on attribute_type_id in component_template_attribute
        $this->createIndex(
            'idx-component_template_attribute-attribute_type_id',
            "{{%component_template_attribute}}",
            'attribute_type_id'
        );
		
		//create an index on name in component_attribute_type
        $this->createIndex(
            'idx-component_attribute_type-name',
            "{{%component_attribute_type}}",
            'name'
        );
		
		//create an index on component_template_id in component
        $this->createIndex(
            'idx-component-component_template_id',
            "{{%component}}",
            'component_template_id'
        );
		
		//create an index on component_id in component_attribute
        $this->createIndex(
            'idx-component_attribute-component_id',
            "{{%component_attribute}}",
            'component_id'
        );
		
		//create an index on component_template_attribute_id in component_attribute
        $this->createIndex(
            'idx-component_attribute-component_template_attribute_id',
            "{{%component_attribute}}",
            'component_template_attribute_id'
        );
		
		//create an index on component_id in component_component
        $this->createIndex(
            'idx-component_component-component_id',
            "{{%component_component}}",
            'component_id'
        );
		
		//create an index on linked_component in component_component
        $this->createIndex(
            'idx-component_component-linked_component',
            "{{%component_component}}",
            'linked_component'
        );
		
		//create an index on value in value_integer
        $this->createIndex(
            'idx-value_integer-value',
            "{{%value_integer}}",
            'value'
        );
		
		//create an index on value in value_short_string
        $this->createIndex(
            'idx-value_short_string-value',
            "{{%value_short_string}}",
            'value'
        );
		
		//create an index on value in value_long_string
		$tableName = "{{%value_long_string}}";
        $this->execute( "ALTER TABLE {$tableName} ADD FULLTEXT idxValuLongStringValue(value);" );
		
		//create an index on value in value_money
        $this->createIndex(
            'idx-value_money-value',
            "{{%value_money}}",
            'value'
        );
		
		//create an index on value in value_known_class
        $this->createIndex(
            'idx-value_known_class-value',
            "{{%value_known_class}}",
            'value'
        );
				
		// add foreign key to table `component_template`
        $this->addForeignKey(
            'AttributeComponentTemplate',
            "{{%component_template_attribute}}",
            'component_template_id',
            "{{%component_template}}",
            'id',
            'CASCADE'
        );
		
		// add foreign key to table `component_attribute_type`
        $this->addForeignKey(
            'AttributeType',
            "{{%component_template_attribute}}",
            'attribute_type_id',
            "{{%component_attribute_type}}",
            'id',
            'CASCADE'
        );
		
		// add foreign key to table `component_template`
        $this->addForeignKey(
            'ComponentTemplate',
            "{{%component}}",
            'component_template_id',
            "{{%component_template}}",
            'id',
            'CASCADE'
        );
		
		// add foreign key to table `component`
        $this->addForeignKey(
            'AttributeInstance',
            "{{%component_attribute}}",
            'component_id',
            "{{%component}}",
            'id',
            'CASCADE'
        );
		
		// add foreign key to table `component_template_attribute`
        $this->addForeignKey(
            'AttributeTemplate',
            "{{%component_attribute}}",
            'component_template_attribute_id',
            "{{%component_template_attribute}}",
            'id',
            'CASCADE'
        );
		
		// add foreign key to table `component`
        $this->addForeignKey(
            'ComponentStart',
            "{{%component_component}}",
            'component_id',
            "{{%component}}",
            'id',
            'CASCADE'
        );
		
		// add foreign key to table `component`
        $this->addForeignKey(
            'LinkedComponent',
            "{{%component_component}}",
            'linked_component',
            "{{%component}}",
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "M181021211010New_component_structure should not be reverted. Reverting for development\n";
		
		$this->dropForeignKey('LinkedComponent', "{{%component_component}}");
		$this->dropForeignKey('ComponentStart', "{{%component_component}}");
		$this->dropForeignKey('AttributeTemplate', "{{%component_attribute}}");
		$this->dropForeignKey('AttributeInstance', "{{%component_attribute}}");
		$this->dropForeignKey('ComponentTemplate', "{{%component}}");
		$this->dropForeignKey('AttributeType', "{{%component_template_attribute}}");
		$this->dropForeignKey('AttributeComponentTemplate', "{{%component_template_attribute}}");
		
		$this->dropIndex('idx-component_attribute-component_template_attribute_id', "{{%component_attribute}}");
		$this->dropIndex('idx-component_attribute-component_id', "{{%component_attribute}}");
		$this->dropIndex('idx-component_component-component_id', "{{%component_component}}");
		$this->dropIndex('idx-component_component-linked_component', "{{%component_component}}");
		
		$this->dropIndex('idx-value_integer-value', "{{%value_integer}}");
		$this->dropIndex('idx-value_short_string-value', "{{%value_short_string}}");
		$this->dropIndex('idxValuLongStringValue', "{{%value_long_string}}");
		$this->dropIndex('idx-value_money-value', "{{%value_money}}");
		$this->dropIndex('idx-value_known_class-value', "{{%value_known_class}}");
		
		$this->dropIndex('idx-component-component_template_id', "{{%component}}");
		$this->dropIndex('idx-component_attribute_type-name', "{{%component_attribute_type}}");
		$this->dropIndex('idx-component_template_attribute-attribute_type_id', "{{%component_template_attribute}}");
		$this->dropIndex('idx-component_template_attribute-component_template_id', "{{%component_template_attribute}}");
		$this->dropIndex('idx-component_template_attribute-name', "{{%component_template_attribute}}");
		$this->dropIndex('idx-component_template-name', "{{%component_template}}");
		
		$this->dropTable("{{%component_attribute_trait}}");
		$this->dropTable("{{%component_attribute}}");
		$this->dropTable("{{%component_trait}}");
		$this->dropTable("{{%component_attribute_type}}");
		$this->dropTable("{{%component_template_attribute}}");
		$this->dropTable("{{%component_template}}");
		$this->dropTable("{{%component_component}}");
		
		$this->dropTable("{{%value_integer}}");
		$this->dropTable("{{%value_short_string}}");
		$this->dropTable("{{%value_long_string}}");
		$this->dropTable("{{%value_money}}");
		$this->dropTable("{{%value_known_class}}");
		$this->dropTable("{{%value_variant_object}}");
		$this->dropTable("{{%value_variant_string}}");
		
		$this->dropColumn("{{%component}}", 'deleted');
		$this->dropColumn("{{%component}}", 'last_updated');
		$this->dropColumn("{{%component}}", 'created_at');
		$this->dropColumn("{{%component}}", 'title');
		$this->dropColumn("{{%component}}", 'component_template_id');
	}

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M181021211010New_component_structure cannot be reverted.\n";

        return false;
    }
    */
}
