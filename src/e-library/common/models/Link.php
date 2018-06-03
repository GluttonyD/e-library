<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "link".
 *
 * @property int $id
 * @property int $author_id
 * @property int $publication_id
 * @property int $penname_id
 */
class Link extends \yii\db\ActiveRecord
{

    public function createLink($author_id,$publication_id,$penname_id=null){
        $isExist=self::find()->where(['author_id'=>$author_id])->andWhere(['publication_id'=>$publication_id]);
        if($penname_id){
            $isExist->andWhere(['penname_id'=>$penname_id]);
        }
        $isExist=$isExist->one();
        if($isExist){
            $isExist->delete();
        }
            $this->author_id = $author_id;
            $this->publication_id = $publication_id;
            if($penname_id){
                $this->penname_id=$penname_id;
            }
            $this->save();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'link';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'publication_id','penname_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'publication_id' => 'Publication ID',
        ];
    }
}
