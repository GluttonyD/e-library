<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "author_penname".
 *
 * @property int $id
 * @property int $author_id
 * @property string $penname
 * @property int $added
 */
class AuthorPenname extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'author_penname';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id'], 'integer'],
            [['penname'], 'string', 'max' => 255],
            [['added'],'integer']
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
            'penname' => 'Penname',
        ];
    }

    public function getOrderPennames(){
        return $this->hasMany(PublicationToPenname::className(),['penname_id'=>'id']);
    }
}
