<?php

use yii\db\Migration;

/**
 * Class m180522_072903_add_type_to_publication
 */
class m180522_072903_add_type_to_publication extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('publication','type',$this->bigInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('publication','type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180522_072903_add_type_to_publication cannot be reverted.\n";

        return false;
    }
    */
}
