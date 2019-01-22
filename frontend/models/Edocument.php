<?php

namespace frontend\models;

use Yii;
use yii\helpers\Url;
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

    public function fileExtension($filename)
    {
        $docpath = Url::to('@web/'.$filename);
        $test = Url::to(['folder/index']);
        $doctype = Url::to('@web/images/edocuments');
        $gview = 'https://docs.google.com/gview?url=';
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        switch($ext) {
             case 'JPG': case 'jpg': case 'PNG': case 'png': case 'gif': case 'GIF':
                echo '<a class="doc-img" href="'.$docpath.'" target="_blank" style="background-image: url('.$docpath.');"></a>';
            break;
            case 'zip': case 'rar': case 'tar':
                echo '<a class="doc-img" href="'.$docpath.'" target="_blank" style="background-image: url('.$doctype.'/zip.png");"></a>';
            break;
            case 'doc': case 'docx':
                echo '<a class="doc-img" value="'.$test.'" target="_blank" style="background-image: url('.$doctype.'/word.png");"></a>';
            break;
            case 'pdf': case 'PDF':
                echo '<a class="doc-img" href="'.$docpath.'" target="_blank" style="background-image: url('.$doctype.'/pdf.png");"></a>';
            break;
            case 'xls': case 'xlsx':
                echo '<a class="doc-img" href="'.$docpath.'" target="_blank" style="background-image: url('.$doctype.'/excel.png");"></a>';
            break;
            case 'ppt': case 'pptx':
                echo '<a class="doc-img" href="'.$docpath.'" target="_blank" style="background-image: url('.$doctype.'/powerpoint.png");"></a>';
            break;
            default:
                echo '<a class="doc-img" href="'.$docpath.'" target="_blank" style="background-image: url('.$doctype.'/file.png");"></a>';
        
        }
    }

    public function getTimeElapsedString($full = false) {
        $now = new \DateTime();
        $ago = new \DateTime($this->last_updated);
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
