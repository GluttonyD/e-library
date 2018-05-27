<?php

use yii\db\Migration;

/**
 * Class m180520_115801_add_col_to_link
 */
class m180520_115801_add_col_to_link extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('link','penname_id',$this->bigInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('link','penname_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180520_115801_add_col_to_link cannot be reverted.\n";

        return false;
    }
    */
}
