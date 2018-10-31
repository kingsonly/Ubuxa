<?php
namespace common\start\migrations;

use yii\db\Migration;

/**
 * Class m180906_075230_create_full_DB
 */
class m180906_075230_create_full_DB extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$updates = file_get_contents(__DIR__ . '/db_updates/tycol_main_updates_full_dump_2018_09_06.sql');
		$customers = file_get_contents(__DIR__ . '/db_updates/premux_main_customers_full_dump_2018_09_06.sql');
		$sql = file_get_contents(__DIR__ . '/db_updates/tycol_main_full_dump_and_rename_2018_09_06.sql');
		$this->execute($updates);
		$this->execute($customers);
		$this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180906_075230_create_full_DB cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180906_075230_create_full_DB cannot be reverted.\n";

        return false;
    }
    */
}
