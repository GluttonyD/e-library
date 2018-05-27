<?php

use yii\db\Migration;

/**
 * Class m180514_080524_author_penname
 */
class m180514_080524_author_penname extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('author_penname',[
            'id'=>$this->bigPrimaryKey(),
            'author_id'=>$this->bigInteger(),
            'penname'=>$this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('author_penname');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180514_080524_author_penname cannot be reverted.\n";

        return false;
    }
    */
}
