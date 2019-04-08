<?php

use yii\db\Migration;

/**
 * Class m170916_15000649_adding_oauth2_tables
 */
class m170916_15000649_adding_ovalidation_key extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $sql="
        --
-- Table structure for table `validation_key`
--

CREATE TABLE `tm_validation_key` (
`id` int(11) NOT NULL,
  `key_code` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Indexes for table `validation_key`
--
ALTER TABLE `tm_validation_key`
 ADD PRIMARY KEY (`id`);



--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tm_validation_key`
--
ALTER TABLE `tm_validation_key`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
 ";
        Yii::$app->db->createCommand($sql)->execute();

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
       
        $this->dropTable('{{%validation_key}}');
        

        
    }

}
