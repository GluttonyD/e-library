<?php

use yii\db\Migration;

/**
 * Class m180512_185402_change_author_name
 */
class m180512_185402_change_author_name extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('author','name');
        $this->dropColumn('author','surname');
        $this->dropColumn('author','patronymic');
        $this->addColumn('author','name',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('author','name');
        $this->addColumn('author','name',$this->string());
        $this->addColumn('author','surname',$this->string());
        $this->addColumn('author','patronymic',$this->string());

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180512_185402_change_author_name cannot be reverted.\n";

        return false;
    }
    */
}
