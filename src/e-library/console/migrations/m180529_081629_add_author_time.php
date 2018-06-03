<?php

use yii\db\Migration;

/**
 * Class m180529_081629_add_author_time
 */
class m180529_081629_add_author_time extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('author','added',$this->bigInteger());
        $this->addColumn('author_penname','added',$this->bigInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('author','added');
        $this->dropColumn('author_penname','added');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180529_081629_add_author_time cannot be reverted.\n";

        return false;
    }
    */
}
