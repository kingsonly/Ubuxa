<?php

namespace frontend\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%remark}}".
 *
 * @property int $id
 * @property int $folder_id
 * @property string $project_id
 * @property string $remark_type
 * @property string $remark_date
 * @property string $text
 * @property int $person_id
 * @property string $component_name
 * @property int $view_id
 * @property int $cid
 *
 * @property Folder $folder
 * @property Person $person
 */
class Remark extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%remark}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['folder_id', 'person_id', 'view_id', 'cid'], 'integer'],
            [['project_id', 'remark_date', 'person_id', 'component_name', 'view_id'], 'required'],
            [['remark_date'], 'safe'],
            [['project_id', 'remark_type', 'text'], 'string', 'max' => 255],
            [['component_name'], 'string', 'max' => 50],
            [['folder_id'], 'exist', 'skipOnError' => true, 'targetClass' => Folder::className(), 'targetAttribute' => ['folder_id' => 'id']],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['person_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'folder_id' => 'Folder ID',
            'project_id' => 'Project ID',
            'remark_type' => 'Remark Type',
            'remark_date' => 'Remark Date',
            'text' => 'Text',
            'person_id' => 'Person ID',
            'component_name' => 'Component Name',
            'view_id' => 'View ID',
            'cid' => 'Cid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFolder()
    {
        return $this->hasOne(Folder::className(), ['id' => 'folder_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['id' => 'person_id']);
    }
    public function getFullname()
    {
        return $this->person->first_name." ".$this->person->surname;
    }
    public function trackLocation()
    {
         $getUrlParam = Yii::$app->getRequest()->getQueryParam('r')." ".Yii::$app->getRequest()->getQueryParam('id');
         $str = explode('/',$getUrlParam);
         return $str;
        
    }
    public function goToPage(){
        $baseUrl = Url::base('http');
        return $baseUrl;
    }

    public function getTimeElapsedString($full = false) {
        $now = new \DateTime();
        $ago = new \DateTime($this->remark_date);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}
