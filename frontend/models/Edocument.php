<?php

namespace frontend\models;

use Yii;
use yii\helpers\Url;
use yii\db\Expression;
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
    /*
    public $file_location;
    public $reference;
    public $reference_id;
    public $last_updated;
    public $cid;
    public $ownerId;*/

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
            [['reference_id', 'deleted', 'cid', 'owner_id'], 'integer'],
            [['file_location'], 'string'],
            [['last_updated', 'fromWhere'], 'safe'],
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
            'Owner ID' => 'Owner ID',
            'cid' => 'Cid',
        ];
    }

    //file upload method
    public function upload($edocument, $reference, $referenceID, $filePath, $cid, $ownerId)
    {
            $edocument->file_location = $filePath;
            $edocument->reference = $reference;
            $edocument->reference_id = $referenceID;
            $edocument->last_updated = new Expression('NOW()');
            $edocument->cid = $cid;
            $edocument->ownerId = $referenceID;
            $edocument->fromWhere = $reference;
            $edocument->owner_id = $ownerId;
            $edocument->save();
    }

    //get thumbnail image based on extension
    public function fileExtension($filePath)
    {
        $docpath = Url::to('@web/'.$filePath);
        $doctype = Url::to('@web/images/edocuments');
        $ext = pathinfo($filePath, PATHINFO_EXTENSION); //get file extension
        /* check file extension to determine the file thumbnail */
        switch($ext) {
            case 'JPG': case 'jpg': case 'PNG': case 'png': case 'gif': case 'GIF':
                echo '<a class="doc-img" target="_blank" style="background-image: url('.$docpath.');"></a>';
            break;
            case 'zip': case 'rar': case 'tar':
                echo '<a class="doc-img" target="_blank" style="background-image: url('.$doctype.'/zip.png");"></a>';
            break;
            case 'doc': case 'docx':
                echo '<a class="doc-img" target="_blank" style="background-image: url('.$doctype.'/word.png");"></a>';
            break;
            case 'pdf': case 'PDF':
                echo '<a class="doc-img" target="_blank" style="background-image: url('.$doctype.'/pdf.png");"></a>';
            break;
            case 'xls': case 'xlsx':
                echo '<a class="doc-img" target="_blank" style="background-image: url('.$doctype.'/excel.png");"></a>';
            break;
            case 'ppt': case 'pptx':
                echo '<a class="doc-img" target="_blank" style="background-image: url('.$doctype.'/powerpoint.png");"></a>';
            break;
            default:
                echo '<a class="doc-img" target="_blank" style="background-image: url('.$doctype.'/file.png");"></a>';
        
        }
    }
    /**
    use to get time elapsed, when the document was created. This medthod uses the model last updated to get the date
    **/

    public function getTimeElapsedString($full = false) {
        //$date = strtotime($this->last_updated);
        $now = new \DateTime();
        $ago = new \DateTime($this->last_updated); 
        $diff = $now->diff($ago);

        if ($diff->d >= 1) {
            $result = $ago->format('M j, Y \a\t g:ia');
            return $result;
        } else {
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

    //check if filename already exist and append numbers to it
    public function checkFileName($path, $file){
        $name =  $file->basename; //get file basename
        $ext =  $file->extension; //get file extension
        $filename = $file->name; //get file name

        $filePath = $path.'/'.$filename;
        $newname = $filename; 
        $counter = 1;
        //check if filepath already exists and append a number to the file name
        while (file_exists($filePath)) {
               $newname = $name .'_'. $counter . '.' . $ext; //add counter to filename
               $filePath = $path.'/'.$newname;
               $counter++;
         }
         $newFilePath = $path . '/' . $newname; 
         return $newFilePath;
    }

    public function getUser()
    {
        return $this->hasOne(UserDb::className(), ['id' => 'owner_id']);
    }

    public function getUsername()
    {
        return $this->user->username;
    }


    /***
     * {@inheritdoc}
     * 
     * @details return true so that on afterSave (insert), this instance is subscribed to the current user.
     */
    protected function subscribeInstanceOnInsert()
	{
		return true;
	}

}
