<?php

use yii\db\Migration;

/**
 * Class m180513_170541_add_publication_file
 */
class m180513_170541_add_publication_file extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('publication','file',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('publication','file');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180513_170541_add_publication_file cannot be reverted.\n";

        return false;
    }
    */
}
