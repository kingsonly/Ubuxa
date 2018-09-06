<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
use app\models\EDocument;
?>


<?php 
/*
* EdocumentDisplay widget was built with the aim of reducing the number of time a developer would have to write 
* the html responsible for the view of edocument.
* as such this simply impliesand ensures the code i written once and used over and over again
* this widget has two public properties and 3 public methods
* public $files; // Files hold all files which would be passed down by the controllers
* public $eDocumentSubcomponent; // this features is exclusive to when an edocument has been linked as a subcomponent
********************** Widget Usage *****************************
* use app\boffins_vendor\components\controllers\EdocumentDisplay;
* echo EdocumentDisplay::widget([
		'files'=>$files,
		'eDocumentSubcomponent'	=> $eDocumentSubcomponent
	]);
*/


class EdocumentDisplay extends Widget{
	public $files;  // holds all edocument file_location attribute value
	public $eDocumentSubcomponent; // in the case of edocument as a linked component this property holds the linked edocument file_locatrion attribute value.
	 
	public function init()
	{
		parent::init();
		
	}
	
	
	public function run(){
		
		return $this->render('edocumentdisplayview',[
			'files' => $this->reArrangeFileInGroups(),
		]);
	}
	
	/*
	* Returns a list of file extention types
	* this function is aimed and seperating different files type
	* which is used in the long run to create seperated folders for each file type
	**/
	private function fileTypeAndCategory(){
		$edocumentModel = new EDocument(); // edocument model init 
		$getFileType = $edocumentModel->fileExtentions(); // fetching edocument fileExtention model 
		return $getFileType;
	}
	/*
	*  this method is used to seperate all keys of the extentions, this keys are 
	* Text, image, video etc
	*
	**/
	private function convertFileTypeTokeys(){
		$seperateKeys = array_keys($this->fileTypeAndCategory());
		return $seperateKeys;
	}
	
	/*
	* convertFileStringToArray, Note everyedocument  file_location attribute is actually a list of strings,
	* if multiple files where uploaded , string would contain (,) which seperates each document location
	* as such if file contains (,) it would be converted to array by exploding the string using (,) as a target.
	* if it does not contain (,) then its instantly passed down to the newFileArray array
	* note : same process applies to eDocumentSubcomponent property if the property is not empty and also push to 
	* newFileArray array.
	* Note if both files and eDocumentSubcomponent properties are empty, the an empty array is returned 
	**/
	private function convertFileStringToArray(){
		$file = $this->files;
		$newFileArray = [];
		if(!empty($file)){
			if(strpos($file, ',') !== false){
				$fileArray = explode(',',$file);
				foreach($fileArray as $files){
					array_push($newFileArray,$files);
				}
				
			}else{
			
				array_push($newFileArray,$file);
			}
		}
		
		
		if(!empty($this->eDocumentSubcomponent)){
			foreach($this->eDocumentSubcomponent as $value){
			
				if(strpos($value, ',') !== false){
					$seperateEdoc = explode(',',$value);
					foreach($seperateEdoc as $files){
						array_push($newFileArray,$files);
					}
				}else{

					array_push($newFileArray,$value);
				}
				
			}
		}
		if(empty($file) and empty($this->eDocumentSubcomponent)){
			return [];
		}
		return $newFileArray;
	}
	
	/*
	* value returned back from convertFileStringToArray is sent to this method for a perfect seperation 
	* based on extention type
	* this seperation is used to form the folder structure in the actual view display
	* such folder structure includes (Text doc folde , image folder) etc
	*/
	public function reArrangeFileInGroups(){
		$newFile = [];
		
		if(!empty($this->convertFileStringToArray())){
			foreach($this->convertFileStringToArray() as $files){
				$getExtention = explode('.',$files);
				$fileTypeArray = $this->fileTypeAndCategory();
				$found = null;
				$search = $getExtention[1];
				
				array_walk($fileTypeArray, function ($k, $v) use ($search,&$found ) {
					if (in_array($search, $k)) {

						$found = $v;
					}
				});


				if (array_key_exists($found,$newFile)){
					array_push($newFile[$found],$files);
				}else{
					$newFile[$found][] = $files;
				}
				//array_push($newFile['wert'],$files);
			
		}
		
		return $newFile;
		}else{
			return [];
		}
		
		//return $fileTypeArray;
	}
	
	
	
	
}


?>


