<?php

//namespace console\migrations;

use yii\db\Migration;

/**
 * Class M181017035343Add_clip_table
 */
class M181017035343Add_clip_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		// create a table for ClipBars. 
		$this->createTable("{{%clip}}", [
										'id' => $this->primaryKey(11),
										'bar_id' => $this->integer(11)->comment('where the clip is attached - the clip bar'), 
										'owner_id' => $this->integer(11)->comment('who the clip is for remark? task? other???'),
										'owner_type_id' => $this->integer(11)->comment('clip owner type id'),
										'cid' => $this->integer(),
        ]);
		
		// creates index for owner_id
        $this->createIndex(
            'idx-clip-owner_id',
            "{{%clip}}",
            'owner_id'
        );
		
		// creates index for bar_id
        $this->createIndex(
            'idx-clip-bar_id',
            "{{%clip}}",
            'bar_id'
        );

		$this->createTable("{{%clip_owner_type}}", [
										'id' => $this->primaryKey(11),
										'owner_type' =>    $this->string(255)
																->unique(),
        ]);
		
        // add foreign key to table `clip_owner_type`
        $this->addForeignKey(
            'ClipOwnerType',
            "{{%clip}}",
            'owner_type_id',
            "{{%clip_owner_type}}",
            'id',
            'CASCADE'
        );
		
        // add foreign key to table `clip_bar`
        $this->addForeignKey(
            'ClipBarItem',
            "{{%clip}}",
            'bar_id',
            "{{%clip_bar}}",
            'id',
            'CASCADE'
        );
		
		//insert basic owners (the table MAY never again be modified)
		$this->batchInsert('{{%clip_owner_type}}', ['owner_type'], [ ['remark'], ['task'] ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "M181017035343Add_clip_table should not be reverted. Reverting for development purposes\n";

		$this->dropForeignKey('ClipOwnerType', "{{%clip}}");
		$this->dropForeignKey('ClipBarItem', "{{%clip}}");
		$this->dropIndex('idx-clip-bar_id', "{{%clip}}");
		$this->dropIndex('idx-clip-owner_id', "{{%clip}}");
		$this->dropTable("{{%clip_owner_type}}");
		$this->dropTable("{{%clip}}");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M181017035343Add_clip_table cannot be reverted.\n";

        return false;
    }
    */
}
