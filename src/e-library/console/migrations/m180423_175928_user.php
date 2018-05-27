<?php

use yii\db\Migration;

/**
 * Class m180423_175928_user
 */
class m180423_175928_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user',[
           'id'=>$this->bigPrimaryKey(),
           'username'=>$this->string(),
           'password'=>$this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180423_175928_user cannot be reverted.\n";

        return false;
    }
    */
}
