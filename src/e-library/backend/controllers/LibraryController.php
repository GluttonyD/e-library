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
//        $publications=Publication::find()->joinWith('authors')->orderBy('link.id');
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
        $pennameLink=PublicationToPenname::find()->where(['publication_id'=>$publication_id])->all();
        foreach ($links as $link){
            $link->delete();
        }
        foreach ($pennameLink as $link){
            $link->delete();
        }
        $publication->delete();

        $this->redirect('/library/index');
    }

    public function actionParse(){
        $arr = getBooks("excel/Publications.xlsx");
        Publications::publicationsParse($arr);
    }
}