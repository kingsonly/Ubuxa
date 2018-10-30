<?php

//namespace console\migrations;

use yii\db\Migration;

/**
 * Class M180922075729Add_customer_details
 */
class M180922075729Add_customer_details extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function init()
    {
        $this->db = 'db_tenant';
        parent::init();
    }
	
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		// create an entity table. 
		$sql_entity = <<<IDT
DROP TABLE IF EXISTS `tm_entity`;
CREATE TABLE IF NOT EXISTS `tm_entity` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `entity_type` enum('person','corporation','','') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8 COMMENT='Connects to Persons and Corporate to allow payments from/to ';
IDT;
		echo "The DB: " . $this->db->dsn;
		$this->execute($sql_entity);
		//create person table 
		$this->createTable("{{%person}}", [
										'id' => $this->primaryKey(25),
										'entity_id' => $this->integer(25),
										'first_name' => $this->text(255),
										'surname' => $this->text(255),
										'dob' => $this->date(),
										'create_date' => $this->dateTime(25),
							]);
		//create corporation table 
		$this->createTable("{{%corporation}}", [
										'id' => $this->primaryKey(25),
										'entity_id' => $this->integer(25),
										'name' => $this->text(255),
										'create_date' => $this->dateTime(25),
							]);
		// sql string closed 
		$this->addColumn( "{{%customer}}", 'entity_id', $this->integer(25)->notNull()->after('id') );
		// creates person table index for entity_id
        $this->createIndex(
            'idx-person-entity_id',
            "{{%person}}",
            'entity_id'
        );
		// add person table foreign key to table `entity`
        $this->addForeignKey(
            'PersonEntity',
            "{{%person}}",
            'entity_id',
            "{{%entity}}",
            'id',
            'CASCADE'
        );
		
		// creates corporation table index for entity_id
        $this->createIndex(
            'idx-corporation-entity_id',
            "{{%corporation}}",
            'entity_id'
        );
		// add corporation table foreign key to table `entity`
        $this->addForeignKey(
            'CorporationEntity',
            "{{%corporation}}",
            'entity_id',
            "{{%entity}}",
            'id',
            'CASCADE'
        );
		
		// creates customer table index for entity_id
        $this->createIndex(
            'idx-customer-entity_id',
            "{{%customer}}",
            'entity_id'
        );
		// add customer table foreign key to table `entity`
        $this->addForeignKey(
            'CustomerEntity',
            "{{%customer}}",
            'entity_id',
            "{{%entity}}",
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "M180922075729 Add_customer_details should not reverted. Reverting for development purposes only.\n";
		$this->dropForeignKey('CustomerEntity', "{{%customer}}");
		$this->dropIndex('idx-customer-entity_id', "{{%customer}}");
		$this->dropForeignKey('CorporationEntity', "{{%corporation}}");
		$this->dropIndex('idx-corporation-entity_id', "{{%corporation}}");
		$this->dropForeignKey('PersonEntity', "{{%person}}");
		$this->dropIndex('idx-person-entity_id', "{{%person}}");
		$this->dropColumn("{{%customer}}", 'entity_id');
		$this->dropTable("{{%corporation}}");
		$this->dropTable("{{%person}}");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M180922075729Add_customer_details cannot be reverted.\n";

        return false;
    }
    */
}
