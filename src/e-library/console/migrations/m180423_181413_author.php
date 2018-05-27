<?php

use yii\db\Migration;

/**
 * Class m180423_181413_author
 */
class m180423_181413_author extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('author',[
            'id'=>$this->bigPrimaryKey(),
            'name'=>$this->string(),
            'surname'=>$this->string(),
            'patronymic'=>$this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('author');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180423_181413_author cannot be reverted.\n";

        return false;
    }
    */
}
