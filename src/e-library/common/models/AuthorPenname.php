<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "author_penname".
 *
 * @property int $id
 * @property int $author_id
 * @property string $penname
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
}
