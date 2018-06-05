<?php

namespace backend\controllers;


use yii\web\Controller;
use common\models\Author;
use common\models\PublicationToPenname;
use common\models\AuthorPenname;
use common\models\AuthorSearch;
use yii\data\Pagination;
use app\models\Authors;

class AuthorController extends Controller
{
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
            return true;
        }
        return false;
    }

    public function actionAddAuthor($author_id=null){
        $model=new Authors($author_id);
        if($model->load(\Yii::$app->request->post())&& $model->add($author_id)){
            return $this->redirect('/author/author-index');
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
        return $this->redirect('/author/author-index');
    }
}