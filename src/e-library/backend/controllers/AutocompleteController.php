<?php
/**
 * Created by PhpStorm.
 * User: arito
 * Date: 05.06.2018
 * Time: 16:35
 */

namespace backend\controllers;


use yii\web\Controller;
use common\models\Author;
use common\models\Publication;
use common\models\AuthorPenname;

class AutocompleteController extends Controller
{
    public function actionAutocompleteEdition($edition){
        /**
         * @var Publication $publication
         */
        $array=array();
        $result=array();
        $i=0;
        $publications=Publication::find()->where(['like','edition',$edition])->all();
        foreach ($publications as $publication) {
            $array[$i]=$publication->edition;
            $i++;
        }
        $array=array_unique($array);
        foreach ($array as $item) {
            array_push($result,$item);
        }
        return json_encode($result);
    }
    public function actionAutocompleteAuthors($author_name){
        $array=array();
        $result=array();
        $id_array=array();
        $authors=Author::find()->where(['like','name',$author_name])->all();
        $pennames=AuthorPenname::find()->where(['like','penname',$author_name]);
        /**
         * @var Author $author
         * @var AuthorPenname $penname
         * @var Author $tmp
         */
        foreach ($authors as $author){
            array_push($array,$author->name);
            array_push($id_array,$author->id);
        }
        $pennames=$pennames->orWhere(['in','author_id',$id_array])->all();
        foreach ($pennames as $penname){
            $tmp=Author::find()->where(['id'=>$penname->author_id])->one();
            array_push($array,$tmp->name);
            array_push($array,$penname->penname);
        }
        $array=array_unique($array);
        foreach ($array as $item){
            array_push($result,$item);
        }
        return json_encode($result);
    }
}