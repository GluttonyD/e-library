<?php
/**
 * Created by PhpStorm.
 * User: arito
 * Date: 08.05.2018
 * Time: 1:15
 */

namespace frontend\controllers;


use frontend\models\AuthorInfo;
use frontend\models\PublicationInfo;
use yii\web\Controller;
use common\models\Publication;
use common\models\PublicationSearch;
use common\models\Author;
use common\Models\AuthorSearch;
use yii\data\Pagination;

class LibraryController extends Controller
{
    public function actionIndex()
    {
        $publications = Publication::find()->with('authors')->with('authorPennames');
        $pages = new Pagination(['totalCount' => $publications->count(), 'pageSize' => 10]);
        $model = $publications->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', [
            'publications' => $model,
            'pages' => $pages
        ]);
    }

    public function actionInfo($publication_id)
    {
        $publication=new PublicationInfo($publication_id);
        return $this->render('info', [
            'model' => $publication,
            'modify_id' => $publication_id
        ]);
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

    public function actionAuthorIndex(){
        $authors=Author::find();
        $pages=new Pagination(['totalCount'=>$authors->count(),'pageSize'=>10]);
        $model=$authors->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('author_index',[
            'authors'=>$model,
            'pages'=>$pages
        ]);
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

    public function actionAuthorInfo($author_id){
        $author=new AuthorInfo($author_id);
        return $this->render('author_info',[
            'author'=>$author
        ]);
    }

}