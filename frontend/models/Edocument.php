<?php

namespace frontend\models;

use Yii;
use yii\helpers\Url;
use yii\db\Expression;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
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
    public $file;
	public $controlerLocation = 'frontend';
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
            [['last_updated', 'fromWhere', 'file'], 'safe'],
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
            $edocument->last_updated = date("Y-m-d H:i:s");
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
                echo '<a class="doc-img" target="_blank" style="background-image: url('.str_replace(" ","%20",$docpath).');"></a>';
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

    public function documentUpload($fileName, $cid, $uploadPath, $cidPath, $userId, $reference, $referenceID)
    {
		$this->controlerLocation === 'API'? Url::base(true) != 'http://ubuxaapi.ubuxa.net'?\Yii::$app->params['edocumentUploadPath'] = '../../frontend/web/':\Yii::$app->params['edocumentUploadPath'] = '/var/www/vhosts/ubuxa.net/httpdocs/ubuxa/frontend/web/':\Yii::$app->params['edocumentUploadPath'] = \Yii::$app->basePath.'/web/';
			$edocumentPath = \Yii::$app->params['edocumentUploadPath'];

        $cidDir = $edocumentPath.$uploadPath. $cidPath; //set a varaible for customer id path
        $userDir = $cidDir.'/'.$userId; //set a varaible for user id path
        $dir = $userDir.'/'. date('Ymd'); //set a varaible for path with date

        /* check if  directory with customer id path exists, if not create one. In UNIX systems files are seen as directories hence the need to check if !file_exists*/
        if (!file_exists($cidDir) && !is_dir($cidDir)) {
            FileHelper::createDirectory($cidDir);
        }else if(file_exists($cidDir) && is_dir($cidDir) && !file_exists($userDir) && !is_dir($userDir)){
            FileHelper::createDirectory($userDir);
        }
        $file = UploadedFile::getInstanceByName($fileName); //get uploaded instance of file


        //check if the directory with current date exist
        if (file_exists($dir) && is_dir($dir)) {
            $filePath = $this->checkFileName($dir, $file); //check if file name exist in that directory and append a number to it, if it does.
            if ($file->saveAs($filePath)){
                if($reference == 'folderDetails'){
                    $folder = Folder::findOne($referenceID);
                    $folder->folder_image = $filePath;
                    $folder->save();
                }else{
                    $this->upload($this, $reference, $referenceID, $filePath, $cid, $userId); //upload
                    return $file;
                }
            }
        }else{
            FileHelper::createDirectory($dir, $mode = 0777, $recursive = true); //create directory with read and write permission
            $filePath = $dir . '/' . $file->name;

            if ($file->saveAs($filePath)) {
                if($reference == 'folderDetails'){
                    $folder = Folder::findOne($referenceID);
                    $folder->folder_image = $filePath;
                    $folder->save();
                }else{
                    $this->upload($this, $reference, $referenceID, $filePath, $cid, $userId); //upload
                    return $file;
                }
            }
        }
    }

    public function getUser()
    {
        return $this->hasOne(UserDb::className(), ['id' => 'owner_id']);
    }

    public function getUsername()
    {
        return $this->user->fullName;
    }
}
