<?php

namespace app\models;

use common\models\Author;
use common\models\AuthorPenname;
use common\models\Link;
use common\models\Publication;
use common\models\PublicationToPenname;
use yii\base\Model;
use yii\helpers\VarDumper;
use yii\validators\Validator;
use yii\web\UploadedFile;

class Publications extends Model
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

    public function rules(){
        return [
            [['name','language','year','type'],'required'],
            ['edition','safe'],
            ['data_city','safe'],
            ['data_date','safe'],
            ['data_publication','safe'],
            ['data_pages','safe'],
            ['data_number','safe'],
            [['authors'],'validateAuthors'],
            ['certificate','safe'],
            ['doi','safe'],
            ['scopus','safe'],
            ['index','safe'],
            ['wos','safe'],
            [['file'],'file','extensions'=>'pdf','skipOnEmpty' => true],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'edition' => 'Издание',
            'certificate' => 'Certificate',
            'index' => 'Index',
            'wos' => 'Wos',
            'scopus' => 'Scopus',
            'doi' => 'Doi',
            'link' => 'Link',
            'year' => 'Год',
            'language'=>'Язык',
            'type'=>'Тип публикации'
        ];
    }

    public function validateAuthors($attribute,$params){
        if(!$this->authors[1]){
            $this->addError($attribute,'Должен быть хотя бы один автор');
            return false;
        }
        foreach($this->authors as $author){
            if(!$author['name']){
                $this->addError($attribute,'Имя автора должно быть заполнено');
                return false;
            }
        }
        return true;
    }

    public function __construct($publication_id){
        parent::__construct();
        if($publication_id){
            /**
             * @var Publication $publication
             */
            $this->authors_count=0;
            $publication=Publication::find()->where(['id'=>$publication_id])->one();
//            VarDumper::dump($publication->authorPennames);
            $this->name=$publication->name;
            $this->edition=$publication->edition;
//            foreach ($publication->authors as $item){
//                $this->authors[$this->authors_count]['name']=$item['name'];
//                $this->authors[$this->authors_count]['id']=$item['id'];
//                $this->authors_count++;
//            }
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

    public function addPublication($publication_id){
        $author_order=0;
        if($this->validate()){
            if($publication_id){
                /**
                 * @var Publication $publication
                 */
                $publication=Publication::find()->where(['id'=>$publication_id])->one();
                $links=Link::find()->where(['publication_id'=>$publication->id])->all();
                $penname_links=PublicationToPenname::find()->where(['publication_id'=>$publication->id])->all();
                foreach ($penname_links as $link){
                    $link->delete();
                }
            }
            else {
                $publication = new Publication();
            }
            $publication->setAttr($this);
            /**
             * @var UploadedFile $this->file
             */
            $publication->save();
            if($this->file) {
                if($publication->file){
                    unlink($publication->file);
                }
                $this->file->saveAs('/www/e-library/common/files/' . $publication->id . '.' . $this->file->extension);
                $publication->file = 'files/' . $publication->id . '.' . $this->file->extension;
                $publication->save();
            }
            foreach ($this->authors as $item) {
                self::addAuthor($item,$publication->id,$author_order);
                $author_order++;
            }
            return true;
        }
        return false;
    }

    public static function addAuthor($item,$publication_id,$author_order){
        /**
         * @var Author $author
         * @var AuthorPenname $penname
         */
        $author=Author::find()->where(['name'=>$item['name']])->one();
        $penname=AuthorPenname::find()->where(['penname'=>$item['name']])->one();
        if($author==null) {
            if($penname==null) {
                $author = new Author();
                $author->name = $item['name'];
                $author->save();
                $penname=new AuthorPenname();
                $penname->penname=$item['name'];
                $penname->author_id=$author->id;
                $penname->original=1;
                $penname->save();
                $link = new Link();
                $link->createLink($author->id,$publication_id);
                $penname_link=new PublicationToPenname();
                $penname_link->createLink($author->id,$publication_id,$penname->id);
                return true;
            }
            else{
                $author=Author::find()->where(['id'=>$penname->author_id])->one();
                $link=new PublicationToPenname();
                $link->createLink($author->id,$publication_id,$penname->id);
                return true;
            }
        }
        $author->save();
        $link = new Link();
        $link->createLink($author->id,$publication_id);
        $penname_link=new PublicationToPenname();
        $penname_link->createLink($author->id,$publication_id,$penname->id);
        return true;
    }

    public static function publicationsParse($publications){
        foreach ($publications as $item){
            $publication_id=self::addPublicationFromArray($item);
            $item['autors']=trim($item['autors']);
            $authors=explode(',',$item['autors']);
            foreach ($authors as $tmp){
                $author_id=self::addAuthorFromArray($tmp);
                $link=new Link();
                $link->createLink($author_id,$publication_id);
            }
        }
    }

    private static function addAuthorFromArray($array){
        $array=trim($array);
        $buf=explode('.',$array);
        /**
         * @var Author $author
         */
        $author=Author::find()->where(['name'=>$array])->one();
        if($author==null) {
            $author = new Author();
            $author->name = $array;
            $author->save();
            return $author->id;
        }
        return $author->id;
    }

    private static function addPublicationFromArray($item)
    {
        $item['year']=(string)$item['year'];
        $publication = new Publication();
        $publication->year = $item['year'];
        $publication->name = $item['name'];
        $publication->link = $item['link'];
        $publication->edition = $item['edition'];
        $publication->data_city=(string)$item['outputData'];
        $publication->certificate = $item['vak'];
        $publication->index = $item['rinc'];
        $publication->wos =$item['wos'];
        $publication->scopus = $item['scopus'];
        $publication->doi = $item['doi'];
        $publication->language='rus';
        $publication->save();
        return $publication->id;
    }

}