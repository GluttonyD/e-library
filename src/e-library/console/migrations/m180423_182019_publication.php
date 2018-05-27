<?php

use yii\db\Migration;

/**
 * Class m180423_182019_publication
 */
class m180423_182019_publication extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('publication',[
            'id'=>$this->bigPrimaryKey(),
            'name'=>$this->string(),
            'edition'=>$this->string(), //Издание
            'out_data'=>$this->string(), //Выходные данные
            'certificate'=>$this->string(), //ВАК
            'index'=>$this->string(), //РИНЦ
            'wos'=>$this->string(),
            'scopus'=>$this->string(),
            'doi'=>$this->string(),
            'link'=>$this->string(),
            'year'=>$this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('publication');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180423_182019_publication cannot be reverted.\n";

        return false;
    }
    */
}
