<?php

use yii\db\Migration;

/**
 * Class m180623_123844_add_origin_to_penname
 */
class m180623_123844_add_origin_to_penname extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('author_penname','original',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('author_penname','original');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180623_123844_add_origin_to_penname cannot be reverted.\n";

        return false;
    }
    */
}
