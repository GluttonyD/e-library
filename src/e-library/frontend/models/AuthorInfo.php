<?php
/**
 * Created by PhpStorm.
 * User: arito
 * Date: 23.05.2018
 * Time: 14:58
 */

namespace frontend\models;


use common\models\Author;
use common\models\AuthorPenname;
use yii\base\Model;

class AuthorInfo extends Model
{
    public $name;
    public $pennames=array();

    public function __construct($id)
    {
        parent::__construct();
        /**
         * @var Author $author
         * @var AuthorPenname $penname
         */
        $author=Author::find()->where(['id'=>$id])->one();
        $this->name=$author->name;
        $pennames=AuthorPenname::find()->where(['author_id'=>$author->id])->all();
        foreach ($pennames as $penname){
            array_push($this->pennames,$penname->penname);
        }
    }
}