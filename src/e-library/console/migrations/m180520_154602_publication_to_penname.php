<?php

use yii\db\Migration;

/**
 * Class m180520_154602_publication_to_penname
 */
class m180520_154602_publication_to_penname extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('publication_to_penname',[
            'id'=>$this->bigPrimaryKey(),
            'author_id'=>$this->bigInteger(),
            'penname_id'=>$this->bigInteger(),
            'publication_id'=>$this->bigInteger()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('publication_to_penname');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180520_154602_publication_to_penname cannot be reverted.\n";

        return false;
    }
    */
}
