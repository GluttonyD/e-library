<?php

use yii\db\Migration;

/**
 * Class m180514_154604_add_lang_publication
 */
class m180514_154604_add_lang_publication extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('publication','language',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('publication','language');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180514_154604_add_lang_publication cannot be reverted.\n";

        return false;
    }
    */
}
