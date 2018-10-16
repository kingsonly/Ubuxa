<?php

namespace console\migrations;

use yii\db\Migration;

/**
 * Class M181011025935Create_ClipBar
 */
class M181011025935Create_ClipBar extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		// create a table for ClipBars. 
		$this->createTable("{{%clip_bar}}", [
										'id' => $this->primaryKey(11),
										'owner_id' => $this->integer(11), //where the clib bar resides
										'owner_type_id' => $this->integer(11),
										'capacity' =>  $this->integer()
															->defaultValue(0)
															->comment('maximum number of clips allowed 0 means no limit'),
        ]);
		
		// creates index for owner_id
        $this->createIndex(
            'idx-clip_bar-owner_id',
            "{{%clip_bar}}",
            'owner_id'
        );

		$this->createTable("{{%clip_bar_owner_type}}", [
										'id' => $this->primaryKey(11),
										'owner_type' =>    $this->string(255)
																->unique(),
        ]);
		
        // add foreign key to table `clip_bar_owner_type`
        $this->addForeignKey(
            'ClipBarOwnerType',
            "{{%clip_bar}}",
            'owner_type_id',
            "{{%clip_bar_owner_type}}",
            'id',
            'CASCADE'
        );		
		
		//insert basic owners (the table MAY never again be modified)
		$this->batchInsert('{{%clip_bar_owner_type}}', ['owner_type'], [ ['folder'], ['component'] ]);

    }


    

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "M181011025935Create_ClipBar is a permanent feature and should not be reverted.\n";
		$this->dropForeignKey('ClipBarOwnerType', "{{%clip_bar}}");
		$this->dropIndex('idx-clip_bar-owner_id', "{{%clip_bar}}");
		$this->dropTable("{{%clip_bar_owner_type}}");
		$this->dropTable("{{%clip_bar}}");


    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M181011025935Create_ClipBar cannot be reverted.\n";

        return false;
    }
    */
}
