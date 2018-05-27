<?php

use yii\db\Migration;

/**
 * Class m180423_183932_publication_to_author
 */
class m180423_183932_publication_to_author extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('link',[
            'id'=>$this->bigPrimaryKey(),
            'author_id'=>$this->bigInteger(),
            'publication_id'=>$this->bigInteger()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('link');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180423_183932_publication_to_author cannot be reverted.\n";

        return false;
    }
    */
}
