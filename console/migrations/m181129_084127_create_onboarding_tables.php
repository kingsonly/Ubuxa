<?php

use yii\db\Migration;

/**
 * Class m181121_073016_Create_onboadring_tables
 */
class m181129_084127_create_onboarding_tables extends Migration
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
        // create a table for onboarding 
        $this->createTable("{{%onboarding}}", [
                                        'id' => $this->primaryKey(11),
                                        'user_id' => $this->integer(11)->comment('foreign key to user table'), 
                                        'group_id' => $this->integer(11)->comment('the onboarding group this row is for'), 
                                        'status' => $this->integer(11)->comment('a count of how many times the user has viewed this group?'),
        ]);
        
        //this is a table for onboarding groups 
        $this->createTable("{{%onboarding_group}}", [
                                        'id' => $this->primaryKey(11),
                                        'group_name' => $this->string(255)->comment('The name of the onboarding group (task, remarks etc)'), 
                                        'group_status' => $this->boolean()->comment('whether or not this onboarding group is active or not'),
        ]);

        $this->batchInsert('{{%onboarding_group}}', ['group_name', 'group_status'], [
            ['task', '1'], 
            ['remark', '1'], 
            ['folder', '1'],
            ['subfolder', '1'],
            ['main', '1'],
            ['component', '0']
        ]);
        
        // creates task_assigned_user table index for task_id
        $this->createIndex(
            'idx-onboarding-user_id',
            "{{%onboarding}}",
            'user_id'
        );
        // creates task_assigned_user table index for user_id
        $this->createIndex(
            'idx-onboarding-group_id',
            "{{%onboarding}}",
            'group_id'
        );
        // add task_assigned_user table foreign key to table `task`
        $this->addForeignKey(
            'OnboardingUser',
            "{{%onboarding}}",
            'user_id',
            "{{%user}}",
            'id',
            'CASCADE'
        );
        // add task_assigned_user table foreign key to table `user`
        $this->addForeignKey(
            'OnboardingGroup',
            "{{%onboarding}}",
            'group_id',
            "{{%onboarding_group}}",
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181121_073016_Create_onboadring_tables should not be reverted. Reverting for development only\n";

        $this->dropForeignKey('OnboardingGroup', "{{%onboarding}}");
        $this->dropForeignKey('OnboardingUser', "{{%onboarding}}");
        $this->dropIndex('idx-onboarding-group_id', "{{%onboarding}}");
        $this->dropIndex('idx-onboarding-user_id', "{{%onboarding}}");
        $this->dropTable("{{%onboarding_group}}");
        $this->dropTable("{{%onboarding}}");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181121_073016_Create_onboadring_tables cannot be reverted.\n";

        return false;
    }
    */
}