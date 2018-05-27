<?php
/**
 * Created by PhpStorm.
 * User: arito
 * Date: 23.04.2018
 * Time: 22:48
 */

namespace backend\controllers;

include "../web/PHPExcel/xls_to_db.php";

use app\models\Authors;
use common\models\AuthorPenname;
use common\models\AuthorSearch;
use common\models\PublicationSearch;
use app\models\Publications;
use common\models\Author;
use common\models\Publication;
use common\models\PublicationToPenname;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Link;
use yii\web\UploadedFile;

class LibraryController extends Controller
{
    public function beforeAction($action)
    {
        if(\Yii::$app->user->isGuest){
            return $this->redirect('/site/login');
        }
        else{
            return true;
        }
    }

    public function actionIndex($orderBy=null){
        $publications=Publication::find()->with('authors')->with('authorPennames');
        $pages=new Pagination(['totalCount'=>$publications->count(),'pageSize'=>10]);
        $model=$publications->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index',[
            'publications'=>$model,
            'pages'=>$pages
        ]);
    }

    public function actionAddPublication($publication_id=null){
        $publication = new Publications($publication_id);
        if($publication->load(\Yii::$app->request->post()) ){
            $publication->file=UploadedFile::getInstance($publication,'file');
            if($publication->addPublication($publication_id)) {
                return $this->redirect('index');
            }
            else{
                return $this->render('add',[
                    'model'=>$publication,
                    'modify_id'=>$publication_id
                ]);
            }
        }
        else{
            return $this->render('add',[
                'model'=>$publication,
                'modify_id'=>$publication_id
            ]);
        }
    }

    public function actionSearchPublications($order=null){
        $searchData=new PublicationSearch();
        $searchData->load(\Yii::$app->request->post());
        $searchData->search($order);
        if($searchData->publications!=null) {
            return json_encode($searchData->standardNames);
        }
        else
            return 'null';
    }

    public function actionDeletePublication($publication_id){

        $publication=Publication::find()->where(['id'=>$publication_id])->one();
        $links=\common\models\Link::find()->where(['publication_id'=>$publication_id])->all();
        $publication->delete();
        foreach ($links as $link){
            $link->delete();
        }
        $this->redirect('/library/index');
    }

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


    public function actionAuthorIndex(){
        $authors=Author::find();
        $pages=new Pagination(['totalCount'=>$authors->count(),'pageSize'=>10]);
        $model=$authors->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('author_index',[
            'authors'=>$model,
            'pages'=>$pages
        ]);
    }

    public function actionAuthorErase($author_id,$publication_id){
        if($publication_id) {
            $link = \common\models\Link::find()->where(['publication_id' => $publication_id])->andWhere(['author_id' => $author_id])->one();
            if(!$link){
                $link=PublicationToPenname::find()->where(['publication_id' => $publication_id])->andWhere(['penname_id' => $author_id])->one();
            }
            $link->delete();
        }
        return true;
    }

    public function actionAddAuthor($author_id=null){
        $model=new Authors($author_id);
        if($model->load(\Yii::$app->request->post())&& $model->add($author_id)){
            return $this->redirect('/library/author-index');
        }
        else{
            return $this->render('add_author',[
                'model'=>$model,
                'author_id'=>$author_id
            ]);
        }
    }

    public function actionAuthorSearch(){
        $model=new AuthorSearch();
        $model->load(\Yii::$app->request->post());
        $model->search();
        return $this->render('author_index',[
            'authors'=>$model->authors,
            'pages'=>$model->pages,
        ]);
    }

    public function actionPennameErase($penname_id){
        $penname=AuthorPenname::find()->where(['id'=>$penname_id])->one();
        $penname->delete();
        return true;

    }

    public function actionAuthorDelete($author_id){
        Authors::delete($author_id);
        return $this->redirect('/library/author-index');
    }

    public function actionParse(){
        $arr = getBooks("excel/Publications.xlsx");
        Publications::publicationsParse($arr);
    }
}