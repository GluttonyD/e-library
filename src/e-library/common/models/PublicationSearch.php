<?php

namespace common\models;


use common\models\Author;
use common\models\Link;
use common\models\Publication;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\data\Pagination;

class PublicationSearch extends Model
{
    public $publications;
    public $pages;
    public $data;
    public $standardNames = array(array());

    public $author_name = null;
    public $publication_name = null;
    public $publication_edition = null;
    public $year_from = null;
    public $year_to = null;
    public $scopusID = null;
    public $language = null;
    public $index = null;
    public $certificate = null;
    public $doi = null;
    public $wos = null;
    public $type=null;

    public function rules()
    {
        return [
            [['author_name', 'publication_name', 'publication_edition', 'doi', 'wos', 'scopusID', 'language', 'index', 'certificate'], 'string'],
            [['year_from', 'year_to','type'], 'integer'],
        ];
    }

    public function search($order)
    {
        if ($this->validate()) {
            $model = Publication::find()->with('authors')->with('authorPennames');
            if ($this->publication_name) {
                $model->where(['like', 'name', $this->publication_name]);
            }
            if ($this->publication_edition) {
                $model->andWhere(['like', 'edition', $this->publication_edition]);
            }
            if ($this->author_name) {
                /**
                 * @var Author $author
                 * @var Link $link
                 * @var AuthorPenname $penname
                 * @var PublicationToPenname $penname_link
                 */
                $authors = Author::find()->where(['like', 'name', $this->author_name])->all();
                $pennames=AuthorPenname::find()->where(['like','penname',$this->author_name]);
                $pennames_array=array();
                $authors_array = array();
                $link_array = array();
                foreach ($authors as $author) {
                    array_push($authors_array, $author->id);
                }
                $pennames=$pennames->orWhere(['in','author_id',$authors_array])->all();
                foreach ($pennames as $penname){
                    array_push($pennames_array,$penname->author_id);
                    array_push($authors_array,$penname->author_id);
                }
                $links = Link::find()->where(['in', 'author_id', $authors_array])->all();
                $pennames_link=PublicationToPenname::find()->where(['in','author_id',$pennames_array])->all();
                foreach ($links as $link) {
                    array_push($link_array, $link->publication_id);
                }
                foreach ($pennames_link as $penname_link){
                    array_push($link_array,$penname_link->publication_id);
                }
                $model->andWhere(['in', 'id', $link_array]);
            }
            if ($this->year_from) {
                $model->andWhere(['>=', 'year', $this->year_from]);
            }
            if ($this->year_to) {
                $model->andWhere(['<=', 'year', $this->year_to]);
            }
            if ($this->doi) {
                $model->andWhere(['doi' => $this->doi]);
            }
            if ($this->wos) {
                $model->andWhere(['wos' => $this->wos]);
            }
            if ($this->scopusID) {
                $model->andWhere(['scopus' => $this->scopusID]);
            }
            if ($this->language) {
                $model->andWhere(['language' => $this->language]);
            }
            if($this->type){
                $model->andWhere(['type'=>$this->type]);
            }
            if ($this->index) {
                $model->andWhere(['index' => '+']);
            }
            if ($this->certificate) {
                $model->andWhere(['certificate' => '+']);
            }
            if ($order == 'ASC') {
                $model->orderBy(['year' => SORT_ASC]);
            }
            if ($order == 'DESC') {
                $model->orderBy(['year' => SORT_DESC]);
            }
            $this->publications = $model->all();
            /**
             * @var Publication $item
             */
            $i = 0;
            foreach ($this->publications as $item) {
                $this->standardNames[$i]['name'] = $item->getStandardName();
                $this->standardNames[$i]['id'] = $item->id;
                $this->standardNames[$i]['file'] = $item->file;
                $i++;
            }
        }
    }

}