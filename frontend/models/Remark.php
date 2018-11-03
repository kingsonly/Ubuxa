<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\BoffinsArRootModel;


/**
 * This is the model class for table "{{%remark}}".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $remark_date
 * @property string $text
 * @property int $cid
 */
class Remark extends BoffinsArRootModel
{
    /**
     * {@inheritdoc}
     */
	public const DEFAULT_PARENT_ID = 0;
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
            [['parent_id', 'cid', 'person_id'], 'integer'],
            [['remark_date','last_updated','text', 'ownerId'], 'safe'],
            [['text'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'remark_date' => 'Remark Date',
            'text' => 'Text',
            'person_id' => 'Person Id',
            'cid' => 'Cid',
        ];
    }

    public function remarkfetchall($perpage, $popsisi,$modelName,$barId){
        $query = new \yii\db\Query();
        $query  ->select([
        'tm_remark.id AS remarkId',
        'tm_remark.parent_id AS remarkParentId',
        'tm_remark.text AS remarkText',
        ]
        )  
        ->from('tm_remark')
        ->join('INNER JOIN', 'tm_clip',
            'tm_remark.id =tm_clip.owner_id')      
        ->join('INNER JOIN', 'tm_clip_bar', 
            'tm_clip.bar_id =tm_clip_bar.id')
        ->join('INNER JOIN', 'tm_clip_bar_owner_type', 
            'tm_clip.owner_type_id =tm_clip_bar_owner_type.id')
        ->where(['tm_clip_bar.owner_id' => $barId,'tm_clip_bar_owner_type.owner_type'=>$modelName,'tm_remark.parent_id'=>0])
        ->orderBy('tm_remark.id DESC')
        ->limit($perpage)
        ->offset($popsisi)
        ->all()  ; 
        
        $command = $query->createCommand();
        $data = $command->queryAll();
        return $data;
    }

    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['id' => 'person_id']);
    }
    public function getFullname()
    {
        return $this->person->first_name." ".$this->person->surname;
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
