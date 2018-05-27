<?php

use yii\db\Migration;

/**
 * Class m180514_170041_change_out_data
 */
class m180514_170041_change_out_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('publication','out_data');
        $this->addColumn('publication','data_city',$this->string());
        $this->addColumn('publication','data_publication',$this->string());
        $this->addColumn('publication','data_pages',$this->string());
        $this->addColumn('publication','data_number',$this->string());
        $this->addColumn('publication','data_date',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('publication','out_data',$this->string());
        $this->dropColumn('publication','data_city');
        $this->dropColumn('publication','data_publication');
        $this->dropColumn('publication','data_pages');
        $this->dropColumn('publication','data_number');
        $this->dropColumn('publication','data_date');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180514_170041_change_out_data cannot be reverted.\n";

        return false;
    }
    */
}
