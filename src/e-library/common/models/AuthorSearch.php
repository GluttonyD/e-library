<?php
/**
 * Created by PhpStorm.
 * User: arito
 * Date: 08.05.2018
 * Time: 10:31
 */

namespace common\models;


use yii\base\Model;
use yii\data\Pagination;

class AuthorSearch extends Model
{
    public $name;

    public $pages;
    public $authors;

    public function rules()
    {
        return [
          [['name'],'string'],
        ];
    }

    public function search(){
        if($this->validate()){
            $authors=Author::find();
            if($this->name){
                /**
                 * @var AuthorPenname $item
                 */
                $array=array();
                $authors->where(['like','name',$this->name]);
                $pennames=AuthorPenname::find()->where(['like','penname',$this->name])->all();
                foreach ($pennames as $item){
                    array_push($array,$item->author_id);
                }
                $authors->orWhere(['in','id',$array]);
            }
            $this->pages = new Pagination(['totalCount' => $authors->count(), 'pageSize' => 10]);
            $this->authors=$authors->offset($this->pages->offset)->limit($this->pages->limit)->all();
        }
    }
}