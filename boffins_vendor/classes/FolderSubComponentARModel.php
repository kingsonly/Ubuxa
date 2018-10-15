<?php
/**
 * @copyright Copyright (c) 2017 Tycol Main (By Epsolun Ltd)
 */

namespace boffins_vendor\classes;

use Yii;
use yii\base\Behavior;
use yii\behaviors\AttributeBehavior;
use yii\base\ModelEvent;
use yii\db\ActiveRecord;
use boffins_vendor\behaviors\DeleteUpdateBehavior;
use boffins_vendor\behaviors\DateBehavior;
use boffins_vendor\behaviors\ComponentsBehavior;
use yii\db\ActiveQuery;
use boffins_vendor\classes\StandardQuery;
use frontend\models\FolderComponent;
use frontend\models\UserDb;
use frontend\models\EDocFileLocation;
use frontend\models\ComponentManager;


/**
 * This ia an ActiveRecord class strictly for subcomponents of a folder. 
 *
 */

class FolderSubComponentARModel extends ActiveRecord
{
	
	/**
     * Initialise AR. 
	 * Respond to new Events defined in DeleteUpdateBehavior
	 * All child classes must call parent::init() if they override this function. 
	 */
	public $defaltBehaviour;
	
	/**
     * upload_file would hold all the needed files to be uploaded when a file is linked
	 */
	public $upload_file;
	
	/* 
	 * Variable to indicate to stop ComponentBehavior from acting on any events.
	 */
	public $stopComponentBehaviors = false;
	
	/*
	 * @array or string to list date values in the ARModel/Child class
	 */
	public $dateAttributes = array( 'last_updated' );
	
	/*
	 * an array of folders to link this component to. 
	 * public because ComponentBehavior classes needs access to it.
	 */
	public $_foldersList = [];
	
	/*
	 * an array of linked components (component ids). 
	 * public because ComponentBehavior classes needs access to it.
	 */
	public $_componentsList = [];
	
	/**
	 * An array of users you want to grant access to this component. 
	 */
	protected $_users = [];
	
	/***
	 * Type of item you are linking - either a folder or a subcomponent
	 */
	public $itemType = '';
	
	/***
	 
	
	/***
	 * The ID of the Item to be linked - could be either a folder reference (tyc_ref) or component id
	 */
	public $itemID = '';
	 
	/* 
	 * junction model that links this Compoent AR Model to other components i.e. the component to component AR Model (which represents the table)
	 * if a component uses a non standard junction table, then the AR model for the component needs to override 
	 * getJunctionModel() to return the class name of the AR Model which represents the custom junction table. 
	 * A standard junction table should use the same name of the component and append "_component"
	 * In Yii this translates to the same name as the component AR Model (first letter capitalised) and appended with "Component"
	 */
	protected $_junction = false;
	
	/* 
	 * the junction table should use a foreign key to the component table's id as follows - 
	 * name of the component AR Model suffixed with "_id" if the component primary key name is "id"
	 * Otherwise, use the primary key name. In any case, if the junction foreign key is not the component name with the the suffix "_id"
	 * then getJunctionFK should return the corect Foreign Key Name. 
	 */
	protected $_junctionFK = false;
	
	/* 
	 * attach soft delete events set by DeleteUpdateBehavior and create component events 
	 * created by componentBehavior
	 */
	public function init() 
	{
		 $this->on(DeleteUpdateBehavior::EVENT_BEFORE_SOFT_DELETE, [$this, 'beforeSoftDelete']);
		 $this->on(DeleteUpdateBehavior::EVENT_AFTER_SOFT_DELETE, [$this, 'afterSoftDelete']);
		 $this->on(DeleteUpdateBehavior::EVENT_BEFORE_UNDO_DELETE, [$this, 'beforeUndoDelete']);
		 $this->on(DeleteUpdateBehavior::EVENT_AFTER_UNDO_DELETE, [$this, 'afterUndoDelete']);
		 $this->on(ComponentsBehavior::EVENT_BEFORE_CREATE_COMPONENT, [$this, 'beforeCreateComponent']);
		 $this->on(ComponentsBehavior::EVENT_AFTER_CREATE_COMPONENT, [$this, 'afterCreateComponent']);
		 $this->on(ComponentsBehavior::EVENT_BEGIN_LINKING, [$this, 'beginLinking']);
	}
	
	public function rules()
    {
        return [
            [['upload_file'], 'file', 'skipOnEmpty' => false, 'extensions' => $this->mergeAllExtentionsAssStrin(), 'maxFiles' => 4],
        ];
    }
	
	/* 
	 * Final function returns a merged array of the base behaviors and the custom behaviors created by user
	 * Function cannot be overridden by child classes. Use 'myBehaviors' to assign new behaviors
	 */
	final public function behaviors() 
	{
		return $this->stopComponentBehaviors ? [] : $this->_mergeBehaviours( $this->_baseBehaviors(), $this->myBehaviors() );		
	}
	
	/*
	 * Merges two behaviors. Expects to merge a base behavior (internally defined) 
	 * and custom behaviors defined by the user. Those behaviors common to the base behavior will
	 * be ovewritten by the custom behavior.
	 * @params $base - expexts a base behavior 
	 * @param $customBehaviors - optional should be the custom behaviors set by the user.
	 */
	private function _mergeBehaviours($base, $customBehaviors = array()) 
	{
		$mergedBehaviors = array();
		
		//First merge with base 
		foreach ($customBehaviors as $customBehaviorKey => $customBehaviorValue) {
			$found = false;
			foreach ($base as $baseBehaviorKey => $baseBehaviorValue) {
				if ( is_array($baseBehaviorValue) && is_array($customBehaviorValue) ) {
					if ( !empty($baseBehaviorValue['class']) && !empty($customBehaviorValue['class']) ) {
						if ( $baseBehaviorValue['class'] == $customBehaviorValue['class'] ) {
							$found = true;
							try {
								$mergedBehaviors[$customBehaviorKey] = $baseBehaviorKey == $customBehaviorKey ? array_merge($baseBehaviorValue, $customBehaviorValue) : $customBehaviorValue;
							} catch(Exception $e) {
								trigger_error("The base = {$baseBehaviorValue} and custom {$customBehaviorValue} ");
							}
						}
					} else {
						trigger_error("Behavior incorrectly set! - " . __METHOD__, E_USER_ERROR );
					}
				} elseif ( is_string($baseBehaviorValue) || is_string($customBehaviorValue) ) {
					if ( $this->_classString($baseBehaviorValue) == $this->_classString($customBehaviorValue) ) {
						$found = true;
						try {
							$mergedBehaviors[$customBehaviorKey] = $baseBehaviorKey == $customBehaviorKey ? $this->merge_string_array($baseBehaviorValue, $customBehaviorValue) : $customBehaviorValue;
						} catch(Exception $e) {
							trigger_error("The base = {$baseBehaviorValue} and custom {$customBehaviorValue} ");
						}
						//merge_string_array as one of the behaviors is a string not an array. 
					}
				} else {
					//neither is a string or array trigger error
					trigger_error("Behavior type neither strig nor array? - " . __METHOD__, E_USER_ERROR );
				}
			}
						
			if (!$found) {
				//must be a new behavior 
				$mergedBehaviors[$customBehaviorKey] = $customBehaviorValue;
			}
		}
		return array_merge($this->_baseBehaviors(), $mergedBehaviors);
	}
	
	/*
	 * Returns the class string of a behavior. 
	 * if the behavior is simply a class string, returns the class string. 
	 * if the behavior it returns the array item in the 'class' key. Returns false if this is empty
	 * returns null if the class found is not a valid class.
	 * @params string or array variables. 
	 */
	private function _classString($item) //returns the class name as stored in an array/string, however, 'className' is already taken 
	{
		if ( is_array($item) ) {
			if ( !empty($item['class']) ) {
				return class_exists($item['class']) ? $item['class'] : false;
			} else {
				return false;
			}
		} else {
			return class_exists($item) ? $item : null;
		}
	}
	
	/**
	 * Merges two items which can be either an array or a string. 
	 * latter items in the parameter list will overwrite earlier ones.
	 * Should be extendable to accept multiple items but currently limited to 2.
	 * @params string or array variables. 
	 */
	public function merge_string_array() 
	{	
		$result = array();
		$args = func_get_args();
		$arrayItem = array();
		$otherItem = '';
		$firstIsPreferred = false;
		$continue = true;
		if ( is_array($args[0]) ) { 
			$arrayItem = $args[0];
			$otherItem = $args[1];
		} elseif ( is_array($args[1]) ) {
			$arrayItem = $args[1];
			$otherItem = $args[0];
			$firstIsPreferred = true;
		} else {
			$result = $args[0] === $args[1] ? $args[0] : $args[1];
			$continue = false;
 		}
		
		if ( $continue ) {
			foreach ( $arrayItem as $key => $item1 ) {
				if ( ! is_array($otherItem) ) {
					$result[$key] = $firstIsPreferred ? $this->merge_string_array($otherItem, $item1) : $this->merge_string_array($item1, $otherItem);
				} else {
					foreach ( $otherItem as $item2 ) {
						$result[$key] += $this->merge_string_array($item1, $item2);
					}
				}
			}
		}
		return $result;
	}
	
	/*
	 * Simply returns a base configuration of behaviors 
	 * to ammend this, the user can set their configurations in 
	 * myBehaviors function. 
	 */
	private function _baseBehaviors() 
	{
		return [
			
			"dateValues" => [
				"class" => DateBehavior::className(),
			],
			
			
			"deleteUpdateBehavior2" => DeleteUpdateBehavior::className(),
			'componentBehavior' => ComponentsBehavior::className(),

			/*"dueDateAfterFind" => [
					
				"class" => TimestampBehavior::className(),
				"attributes" => [
						ActiveRecord::EVENT_AFTER_FIND => "dueDate",
				],
				"value" => function() { return Yii::$app->formatter->asDate($this->dueDate, "MM/dd/Y"); }
			]*/
		];

	}

	/***
	 * placeholder function - to be overridden by user to provide a custom set of behaviors.
	 */
	public function myBehaviors() 
	{
		return array();
	}
	
	/***
	 * placeholder function - to be overridden by user as required.
	 */
	public function beforeSoftDelete() 
	{
	}
	
	/***
	 * placeholder function - to be overridden by user as required.
	 */
	public function afterSoftDelete() 
	{
	}
	
	/***
	 * placeholder function - to be overridden by user as required.
	 */
	public function beforeUndoDelete() 
	{
	}
	
	/***
	 * placeholder function - to be overridden by user as required.
	 */
	public function afterUndoDelete()
	{
	}
	
	/***
	 * placeholder function - to be overridden by user as required.
	 */
	public function beforeCreateComponent()
	{
	}

	/***
	 * placeholder function - to be overridden by user as required.
	 */
	public function afterCreateComponent() {
		// Check if there are files to be uploaded 
		if(!empty($this->upload_file)){
				$this->createLikedEDocument(); // call the behaviour functions to init the likning
			}
			
		if ( !empty($this->itemType) && !empty($this->itemID) )   {
			if(strpos($this->itemType, ',') !== false and strpos($this->itemID, ',') !== false){
				$itemType = array_map('trim', explode(',', $this->itemType));
				$itemId = array_map('trim', explode(',', $this->itemID));
				$folderItemArray =[];
				$componentItemArray =[];
				foreach($itemType as $itemTypeKey => $itemTypeValue ) {
					if($itemTypeValue == 'folder'){
						array_push($folderItemArray,$itemId[$itemTypeKey]) ;
					} else {
						array_push($componentItemArray,(int)$itemId[$itemTypeKey]) ;
					}					
				}
				if(!empty($folderItemArray)){
					$this->setFoldersList($folderItemArray);
				}
				
				if(!empty($componentItemArray)){
					$this->setComponentsList($componentItemArray);
				}
				
			} else {
				switch ($this->itemType) {
					case 'folder' :
						$this->addFolder($this->itemID);
						break;
					default:
						$this->addComponent($this->itemID);
				}
			}
			
			return true;
			
		} else{
			
		}
	}
	
	/***
	 * Link folders ONLY after the component is created (for new components).
	 */
	public function beginLinking($event) 
	{
		
		$this->linkFolders();
		$this->linkComponents();
		$this->grantUsers();
	}
	
	/***
	 * basic before validate function for each component 
	 */
	public function beforeValidate()  
	{
		if ($this->hasAttribute('deleted') && $this->isNewRecord ) {
			$this->deleted = 0;
		}
		return parent::beforeValidate();
	}
	
	/**
	 * ensure this component can be managed by the user who creates it.
	 */
	public function beforeSave($insert)
	{
		if (!parent::beforeSave($insert)) {
			return false;
		}
		
		if ( $this->isNewRecord ) {
			$this->addUser( Yii::$app->user->identity->id );
		}

		return true;
	}
	
	/***
	 * Overriding base active record to use StandardQuery Active Query subclass
	 * StandardQuery only finds items that are not marked for delete
	 * To find items deleted, use deleted()
	 */
	public static function find() 
	{
		return new StandardQuery(get_called_class());
	}
	
	/***
	 * Get the type of a given attribute 
	 */
	public function getAttributeType($attribute)
	{
		return $this->hasAttribute($attribute) ? self::getTableSchema()->columns[$attribute]->type : trigger_error('This attribute ({$attribute})  does not exist: ' . $attribute . ' ' . __METHOD__);
	}
		
	/***
	 * returns a list of the folders as a string. 
	 */ 
	public function getFoldersList() 
	{ 
		return !empty($this->_foldersList) ? implode(',', $this->_foldersList) : 'empty';
		//run function to list folders from folder component table
	}
	
	/*** 
	 * assigns the _foldersList to the value on the right side of the assignment 
	 * if you want to add just one item t the folderlist, use addFolder($value)
	 */
	public function setFoldersList($array) 
	{
		$this->_foldersList = $array;
		//die(implode(',', $this->_foldersList) . ' : ' . $values);
	}
	
	/***
	 * Adds a single folder id to the folderlist array. 
	 */
	public function addFolder($value) 
	{
		$this->_foldersList[] = $value;
	}
	
	/***
	 * returns a list of the components as a string. 
	 */ 
	public function getComponentsList() 
	{
		return !empty($this->_componentsList) ? implode(',', $this->_componentsList) : 'empty';
		//run function to list folders from folder component table
	}
	
	/*** 
	 * assigns the _componentsList to the value on the right side of the assignment 
	 * if you want to add just one item t the componentslist, use addComponents($value)
	 */
	public function setComponentsList($array) 
	{
		$this->_componentsList = $array;
	}
	
	/***
	 * Adds a single components id to the folderlist array. 
	 */
	public function addComponent($value) 
	{
		$this->_componentsList[] = $value;
	}
	
	/***
	 * returns a list of the users as a string. 
	 */ 
	public function getUserList() 
	{
		return !empty($this->_users) ? implode(',', $this->_users) : 'empty';
	}
	
	/***
	 * returns the array of users. 
	 */ 
	public function getUsers() 
	{
		return !empty($this->_users) ? $this->_users : [];
	}
	
	/*** 
	 * assigns the _users array to the value on the right side of the assignment 
	 * if you want to add just one user, use addUser($value)
	 */
	public function setUsers($array) 
	{
		$this->_users = $array;
	}
	
	/***
	 * Adds a single user id to the users array. 
	 */
	public function addUser($value) 
	{
		$this->_users[] = $value;
	}
	
	/*** 
	 * provide an array (or single user) to grant access to this component. 
	 * @param $users expects an array of user ids or a single user id 
	 */
	public function grantUsers( $users = [] ) 
	{
		if ( empty($users) ) {
			$users = $this->getUsers();
		}
		
		$arrUsers = is_array($users) ? $users : array($users);
		foreach ( $arrUsers as $user_id ) {
			if ( UserDb::isUser($user_id) ) {
				$this->_grantOneUser($user_id);
			}
		}
	}
	
	/*
	 * grant access to this component for this user
	 * @param $user a user id
	 */
	private function _grantOneUser($user_id) 
	{
		$cm = new ComponentManager;
		$cm->role = $this->isNewRecord ? ComponentManager::CM_AUTHOR : ComponentManager::CM_USER;
		$cm->component_id = $this->component_id;
		$cm->user_id = $user_id;
		$cm->save(false);
	}

	/*** 
	 * Returns the junction Model. Uses a standard format as described above (see $this->_junction variable definition)
	 * child classes should override this if the value will be different than the standard format
	 */ 
	public function getJunctionModel() 
	{
		if ( $this->_junction === false ) {
			$this->_junction = $this->className() . 'Component';
		}
		return $this->_junction;
	}
	
	/*** 
	 * Returns the foreign key of the junction table i.e. the attribute to use for the junctin table's AR Model. 
	 * if a non standard primary key name/attribute is used for the component, then the foreign key should be the same primary key name/atribute
	 * should be used in the junction table
	 */
	public function getJunctionFK() 
	{
		if ( $this->_junctionFK === false ) {
			$this->_junctionFK = strtolower($this->_getShortClassName()) . '_id';
		}
		return $this->_junctionFK;
	}
	
	/* 
	 * returns the simple, short name of the child component  
	 */	
	public function _getShortClassName()
	{
		$fullClassName = get_class($this); //includes namespace
		$explodeClass = explode("\\", $fullClassName); //split full class name and namespace into parts the last item will have the value you need the first "\" is an escape 
		$shortClassName = end($explodeClass);
		return lcfirst($shortClassName);
	}
	
	
	/* 
	 * Upload files to the upload folder and send file path to be saved in edocument file_location  
	 */	
	public function upload()
    {
        if ($this->validate()) {
			$holdPath = [];
			foreach($this->upload_file as $file){
				$ext = $file->extension;
				$newName = \Yii::$app->security->generateRandomString().".{$ext}";
				$basePath = explode('/',\Yii::$app->basePath);
				\Yii::$app->params['uploadPath'] = \Yii::$app->basePath.'/web/uploads/';
				$path = \Yii::$app->params['uploadPath'] . $newName;
				$dbpath = 'uploads/' . $newName;
				$file->saveAs($path);
				array_push($holdPath,$dbpath);
			}
			if($this->save()){
				foreach($holdPath as $value){
					$eDocModel = new EDocFileLocation();
					$eDocModel->e_document_id = $this->id;
					$eDocModel->file_location = $value;
					$eDocModel->save();
				}
				
			}
			//$this->file_location = implode(",",$holdPath);
			
            return true;
        } else {
            return false;
        }
    }
	
	/* 
	 *  getNumberOfFiles is exclusive to edocument
	 * it helps in the displaying of total files associated to an edocumnet row in the database
	 * this information is used to register the total product count on the listview widget of edocument.
	 */	
	public function getNumberOfFiles(){
		$getFile = $this->fileLocationString; // get file_location column
		/**
		* Check if there is a (,) in the getfile list, if there is convert to array and count the content of the array
		* else pass a static number 1 to the output.
		*/
		if (strpos($getFile , ',') !== false) {
			$convertToArray = explode(',', $getFile);
			$totalFile = count($convertToArray);
		} else {
			$totalFile =1;
		}
		
		return $totalFile;
	}
	
	/*
	* Fetch the  list of all possible extention based on type eg video with a list of video extention 
	* the aim is to be able to fillter document type  based on the extention .
	* Kingsley, why is this not in the DB? Why hard code things???
	*/
	public function fileExtentions(){
		$extentionList = [
				'video' => [
					"3g2",
					"3gp",
					"aaf",
					"asf",
					"avchd",
					"avi",
					"drc",
					"flv",
					"m2v",
					"m4p",
					"m4v",
					"mkv",
					"mng",
					"mov",
					"mp2",
					"mp4",
					"mpe",
					"mpeg",
					"mpg",
					"mpv",
					"mxf",
					"nsv",
					"ogg",
					"ogv",
					"qt",
					"rm",
					"rmvb",
					"roq",
					"svi",
					"vob",
					"webm",
					"wmv",
					"yuv"
			],
				'text' => [
					"applescript",
					"asp",
					"pdf",
					"aspx",
					"atom",
					"bashrc",
					"bat",
					"bbcolors",
					"bib",
					"bowerrc",
					"c",
					"cbl",
					"cc",
					"cfc",
					"cfg",
					"cfm",
					"cmd",
					"cnf",
					"cob",
					"coffee",
					"conf",
					"cpp",
					"cson",
					"css",
					"csslintrc",
					"csv",
					"curlrc",
					"cxx",
					"diff",
					"eco",
					"editorconfig",
					"ejs",
					"emacs",
					"eml",
					"erb",
					"erl",
					"eslintignore",
					"eslintrc",
					"gemrc",
					"gitattributes",
					"gitconfig",
					"gitignore",
					"go",
					"gvimrc",
					"h",
					"haml",
					"hbs",
					"hgignore",
					"hpp",
					"htaccess",
					"htm",
					"html",
					"iced",
					"ini",
					"ino",
					"irbrc",
					"itermcolors",
					"jade",
					"js",
					"jscsrc",
					"jshintignore",
					"jshintrc",
					"json",
					"jsonld",
					"jsx",
					"less",
					"log",
					"ls",
					"m",
					"markdown",
					"md",
					"mdown",
					"mdwn",
					"mht",
					"mhtml",
					"mjs",
					"mkd",
					"mkdn",
					"mkdown",
					"nfo",
					"npmignore",
					"npmrc",
					"nvmrc",
					"patch",
					"pbxproj",
					"pch",
					"php",
					"phtml",
					"pl",
					"pm",
					"properties",
					"py",
					"rb",
					"rdoc",
					"doc",
					"docx",
					"rdoc_options",
					"ron",
					"rss",
					"rst",
					"rtf",
					"rvmrc",
					"sass",
					"scala",
					"scss",
					"seestyle",
					"sh",
					"sls",
					"sql",
					"sss",
					"strings",
					"styl",
					"stylus",
					"sub",
					"sublime-build",
					"sublime-commands",
					"sublime-completions",
					"sublime-keymap",
					"sublime-macro",
					"sublime-menu",
					"sublime-project",
					"sublime-settings",
					"sublime-workspace",
					"svg",
					"terminal",
					"tex",
					"text",
					"textile",
					"tmLanguage",
					"tmTheme",
					"ts",
					"tsv",
					"tsx",
					"txt",
					"vbs",
					"vim",
					"viminfo",
					"vimrc",
					"webapp",
					"xht",
					"xhtml",
					"xml",
					"xsl",
					"yaml",
					"yml",
					"zsh",
					"zshrc"
			],
				'image' => [
					"png",
					"jpg",
					"jpeg",
					"gif",
					"ico",
				]
			];
		return $extentionList;
	}
	
	/**************************************************************************************
	******** Only files listed in the fileExtentions can be uploaded **********************
	******** as such we would need to convert all files to a long list of string***********  
	******** as to attach it to the validation rule of upload_file*************************
	* ****** check ($this->rules) method for better understanding .************************
	**************************************************************************************/
	public function mergeAllExtentionsAssStrin(){
		$video = implode(',' , $this->fileExtentions()['video']);
		$text = implode(',' , $this->fileExtentions()['text']);
		$image = implode(',' , $this->fileExtentions()['image']);
		$joinStrin = $video.','.$text.','.$image;
		return $joinStrin;
	}
	
}