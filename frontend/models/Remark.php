<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\BoffinsArRootModel;
use boffins_vendor\classes\models\{TenantSpecific, TrackDeleteUpdateInterface, ClipperInterface, ClipableInterface};


/**
 * This is the model class for table "{{%remark}}".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $remark_date
 * @property string $text
 * @property int $cid
 */
class Remark extends BoffinsArRootModel implements TenantSpecific, TrackDeleteUpdateInterface, ClipperInterface, ClipableInterface
{
    /**
     * {@inheritdoc}
     */
	public const DEFAULT_PARENT_ID = 0;
	public $fromWhere; // a public attribute only used by clipon behavior
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
            [['parent_id', 'cid', 'user_id'], 'integer'],
            [['remark_date','last_updated','text', 'ownerId','fromWhere'], 'safe'],
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

   
    public function getUser()
    {
        return $this->hasOne(UserDb::className(), ['id' => 'user_id']);
    }
    public function getFullname()
    {
        return $this->user->fullName;
    }
    public function getUserImage()
    {
        return $this->user->profile_image;
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
