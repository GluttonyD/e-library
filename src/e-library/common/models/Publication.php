<?php

namespace common\models;

use app\models\Publications;
use Yii;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "publication".
 *
 * @property int $id
 * @property string $name
 * @property string $edition
 * @property string $data_city
 * @property string $data_date
 * @property string $data_pages
 * @property string $data_number
 * @property string $data_publication
 * @property string $certificate
 * @property string $index
 * @property string $wos
 * @property string $scopus
 * @property string $doi
 * @property string $link
 * @property string $year
 * @property  string $file
 * @property string $language
 * @property string $type
 */
class Publication extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'publication';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'edition', 'data_city', 'data_date', 'data_number', 'data_pages', 'data_publication', 'certificate', 'index', 'wos', 'scopus', 'doi', 'link', 'year', 'language'], 'string', 'max' => 255],
            [['type'],'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
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
            'language'=>'Язык'
        ];
    }

    public function setAttr($publication)
    {
        /**
         * @var Publications $publication
         */
        $this->name = $publication->name;
        $this->edition = $publication->edition;
        $this->data_pages = $publication->data_pages;
        $this->data_publication = $publication->data_publication;
        $this->data_number = $publication->data_number;
        $this->data_date = $publication->data_date;
        $this->data_city = $publication->data_city;
        $this->certificate = $publication->certificate;
        $this->index = $publication->index;
        $this->wos = $publication->wos;
        $this->scopus = $publication->scopus;
        $this->year = $publication->year;
        $this->doi = $publication->doi;
        $this->language = $publication->language;
        $this->type=$publication->type;
    }

    public function getStandardName()
    {
        $standard_name = '';
        if ($this->language == 'eng') {
            foreach ($this->authors as $author)
                $standard_name = $standard_name . $author['name'] . ', ';
            foreach ($this->authorPennames as $author)
                $standard_name = $standard_name . $author['penname'] . ', ';
            $standard_name=trim($standard_name);
            $standard_name=substr($standard_name,0,-1);
            $standard_name.=" ";
            $standard_name .= '"';
            $standard_name .= $this->name;
            $standard_name .= '."';
            $standard_name .= $this->edition;
            if ($this->data_city) {
                $standard_name .= ',' . $this->data_city. ":";
            }
            if ($this->data_date) {
                $standard_name .= $this->data_date;
            }
            if ($this->data_publication) {
                $standard_name .=$this->data_publication;
            }
            $standard_name.='. - '.$this->year;
            if ($this->data_number) {
                $standard_name .= '' . $this->data_number . ' ';
            }
            if ($this->data_pages) {
                $standard_name .= ' p.' . $this->data_pages;
            }
            if ($this->doi || $this->wos || $this->scopus) {
                $standard_name .= ' (';
            }
            if ($this->doi) {
                $standard_name .= 'DOI ' . $this->doi . ' ';
            }
            if ($this->wos) {
                $standard_name .= 'WOS ' . $this->wos . ' ';
            }
            if ($this->scopus) {
                $standard_name .= 'Scopus ID ' . $this->scopus;
            }
            if ($this->doi || $this->wos || $this->scopus) {
                $standard_name .= ')';
            }
        }
        if ($this->language == 'rus') {
            foreach ($this->authors as $author)
                $standard_name = $standard_name . $author['name'] . ', ';
            foreach ($this->authorPennames as $author)
                $standard_name = $standard_name . $author['penname'] . ', ';
            $standard_name=trim($standard_name);
            $standard_name=substr($standard_name,0,-1);
            $standard_name.=" ";
            $standard_name .= $this->name;
            if($this->edition) {
                $standard_name .= ' // ';
            }
            $standard_name .= $this->edition;
            if ($this->data_city) {
                $standard_name .= '. ' . $this->data_city. ' : ';
            }
            if ($this->data_date) {
                $standard_name .=  $this->data_date;
            }
            if ($this->data_publication) {
                $standard_name .= $this->data_publication;
            }
            $standard_name.='. - '.$this->year;
            $standard_name .= '. ';
            if ($this->data_number) {
                $standard_name .= $this->data_number . ' ';
            }
            if ($this->data_pages) {
                $standard_name .= 'c.' . $this->data_pages;
            }
            if ($this->doi || $this->wos || $this->scopus) {
                $standard_name .= ' (';
            }
            if ($this->doi) {
                $standard_name .= 'DOI ' . $this->doi . ' ';
            }
            if ($this->wos) {
                $standard_name .= 'WOS ' . $this->wos . ' ';
            }
            if ($this->scopus) {
                $standard_name .= 'Scopus ID ' . $this->scopus;
            }
            if ($this->doi || $this->wos || $this->scopus) {
                $standard_name .= ')';
            }
        }
        return $standard_name;
    }

    public function getAuthors()
    {
        return $this->hasMany(Author::className(), ['id' => 'author_id'])->viaTable('link', ['publication_id' => 'id']);
    }

    public function getAuthorPennames()
    {
        return $this->hasMany(AuthorPenname::className(), ['id' => 'penname_id'])->viaTable('publication_to_penname', ['publication_id' => 'id']);
    }
}
