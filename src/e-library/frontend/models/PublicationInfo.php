<?php
/**
 * Created by PhpStorm.
 * User: arito
 * Date: 23.05.2018
 * Time: 14:23
 */

namespace frontend\models;


use yii\base\Model;
use common\models\Publication;

class PublicationInfo extends Model
{
    public $name=null;
    public $authors=array(array());
    public $edition=null;
    public $data_city=null;
    public $data_date=null;
    public $data_pages=null;
    public $data_number=null;
    public $data_publication=null;
    public $certificate=null;
    public $index=null;
    public $doi=null;
    public $wos=null;
    public $scopus=null;
    public $language=null;
    public $authors_count=null;
    public $year=null;
    public $file=null;
    public $filePath=null;
    public $type=null;

    public function __construct($publication_id){
        parent::__construct();
        if($publication_id){
            /**
             * @var Publication $publication
             */
            $this->authors_count=0;
            $publication=Publication::find()->where(['id'=>$publication_id])->one();
            $this->name=$publication->name;
            $this->edition=$publication->edition;
            foreach ($publication->authors as $item){
                $this->authors[$this->authors_count]['name']=$item['name'];
                $this->authors[$this->authors_count]['id']=$item['id'];
                $this->authors_count++;
            }
            foreach ($publication->authorPennames as $item){
                $this->authors[$this->authors_count]['name']=$item['penname'];
                $this->authors[$this->authors_count]['id']=$item['id'];
                $this->authors_count++;
            }
            $this->certificate=$publication->certificate;
            $this->index=$publication->index;
            $this->wos=$publication->wos;
            $this->scopus=$publication->scopus;
            $this->data_city=$publication->data_city;
            $this->data_date=$publication->data_date;
            $this->data_number=$publication->data_number;
            $this->data_pages=$publication->data_pages;
            $this->data_publication=$publication->data_publication;
            $this->doi=$publication->doi;
            $this->year=$publication->year;
            $this->language=$publication->language;
            $this->filePath=$publication->file;
            $this->type=$publication->type;
        }
    }
}