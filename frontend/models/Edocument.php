<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\BoffinsArRootModel;
use boffins_vendor\classes\models\{ClipableInterface, ClipperInterface};
/**
 * This is the model class for table "{{%e_document}}".
 *
 * @property int $id
 * @property string $reference
 * @property int $reference_id
 * @property string $file_location
 * @property string $last_updated
 * @property int $deleted
 * @property int $cid
 */

class Edocument extends BoffinsArRootModel implements ClipableInterface, ClipperInterface
{
    /**
     * {@inheritdoc}
     */
    public $fromWhere;

    public static function tableName()
    {
        return '{{%e_document}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reference_id', 'file_location'], 'required'],
            [['reference_id', 'deleted', 'cid'], 'integer'],
            [['file_location'], 'string'],
            [['last_updated', 'fromWhere','ownerId'], 'safe'],
            [['reference'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reference' => 'Reference',
            'reference_id' => 'Reference ID',
            'file_location' => 'File Location',
            'last_updated' => 'Last Updated',
            'deleted' => 'Deleted',
            'cid' => 'Cid',
        ];
    }
}
