<?php
/**
 * Created by PhpStorm.
 * User: arito
 * Date: 13.05.2018
 * Time: 15:13
 */

namespace app\models;


use common\models\Author;
use common\models\AuthorPenname;
use common\models\Link;
use yii\base\Model;
use yii\helpers\VarDumper;

class Authors extends Model
{
    public $name;
    public $pennames=array(array());

    public function __construct($author_id)
    {
        parent::__construct();
        if($author_id){
            /**
             * @var Author $author
             * @var AuthorPenname $penname
             */
            $i=0;
            $author=Author::find()->where(['id'=>$author_id])->one();
            $this->name=$author->name;
            $pennames=AuthorPenname::find()->where(['author_id'=>$author_id])->andWhere(['original'=>0])->all();
            foreach ($pennames as $penname){
                $this->pennames[$i]['penname']=$penname->penname;
                $this->pennames[$i]['id']=$penname->id;
                $i++;
            }
        }
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            ['pennames', 'safe'],
        ];
    }

    public function add($author_id){

        if($this->validate()){
            $author=Author::find()->where(['name'=>$this->name])->one();
            /**
             * @var Author $author
             * @var AuthorPenname $penname
             */
            if(!$author){

                if($author_id){
                    $author=Author::find()->where(['id'=>$author_id])->one();
                }
                else {
                    $author = new Author();
                }
                $author->name=$this->name;
                $author->save();
                if($author_id){
                    $penname=AuthorPenname::find()->where(['author_id'=>$author->id])->andWhere(['original'=>1])->one();
                    $penname->penname=$this->name;
                    $penname->save();
                }
                else {
                    self::addPenname($author->name, $author->id, 1);
                }
            }
            if($this->pennames[0]){
                foreach ($this->pennames as $penname){
                    self::addPenname($penname['penname'],$author->id,0);
                }
            }
            return true;
        }
        return false;
    }

    public static function addPenname($penname,$author_id,$isOriginal){
        /**
         * @var AuthorPenname $author_penname
         */
        $author_penname=AuthorPenname::find()->where(['author_id'=>$author_id])->andWhere(['penname'=>$penname])->one();
        if(!$author_penname){

            $author_penname=new AuthorPenname();
            $author_penname->penname=$penname;
            $author_penname->author_id=$author_id;
            $author_penname->save();
        }
        else{
            $author_penname->penname=$penname;
            $author_penname->author_id=$author_id;
            $author_penname->save();
        }
        $author_penname->original=$isOriginal;
        $author_penname->save();
    }

    public static function delete($author_id){
        $author=Author::find()->where(['id'=>$author_id])->one();
        $links=Link::find()->where(['author_id'=>$author_id])->all();
        $pennames=AuthorPenname::find()->where(['author_id'=>$author_id])->all();
        $author->delete();
        foreach($links as $link){
            $link->delete();
        }
        foreach ($pennames as $penname){
            $penname->delete();
        }
    }
}