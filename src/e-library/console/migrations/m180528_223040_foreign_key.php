<?php

use yii\db\Migration;

/**
 * Class m180528_223040_foreign_key
 */
class m180528_223040_foreign_key extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('publication_to_link','link','publication_id','publication','id');
        $this->addForeignKey('author_to_link','link','author_id','author','id');
        $this->addForeignKey('publication_to_penname','publication_to_penname','publication_id','publication','id');
        $this->addForeignKey('penname_to_penname','publication_to_penname','penname_id','author_penname','id');
        $this->addForeignKey('author_to_penname','author_penname','author_id','author','id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('publication_to_author','link');
        $this->dropForeignKey('author_to_link','link');
        $this->dropForeignKey('publication_to_penname','publication_to_penname');
        $this->dropForeignKey('penname_to_penname','publication_to_penname');
        $this->dropForeignKey('author_to_penname','author_penname');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180528_223040_foreign_key cannot be reverted.\n";

        return false;
    }
    */
}
