<?
namespace boffins_vendor\queue;
use frontend\models\UserDb;
use frontend\models\FolderManager;
use console\models\ConsoleFolder;
use yii\base\BaseObject;
use yii\base\Model;
use yii\queue\redis\Queue;


class FolderUsersQueue extends BaseObject implements \yii\queue\JobInterface
{   
	public $userId;
	public $folderId;
	public $smart;
	public $type;
	public $componentId;
	
    public function execute($queue){
		if($this->type == 'folder'){
			$this->addFolderNewUser();
		}elseif($this->type == 'component'){
			$this->addComponentNewUser();
		}else{
			$this->addFolderNewUser();
		}
        
        
		
    }
	
	public function addFolderNewUser($userId = '', $folderId = '')
	{
		
		if (empty($userId) || empty($folderId) ) {
			$userId = $this->userId;
			$folderId = $this->folderId;
		}
		$folderManagerModel = new FolderManager();
		$folderManagerModel->user_id = $this->userId;
		$folderManagerModel->folder_id = $this->folderId;
		$folderManagerModel->role = 'user';
		
			
		if($folderManagerModel->save(false)){
			
			$this->reQueueEachChildFolder();
		}
	}
	
	public function addComponentNewUser($userId = '', $componentId = '')
	{
		
		if (empty($userId) || empty($componentId) ) {
			$userId = $this->userId;
			$componentId = $this->componentId;
		}
		$componentManagerModel = new ComponentManager();
		$componentManagerModel->user_id = $this->userId;
		$componentManagerModel->component_id = $this->componentId;
		$componentManagerModel->role = 'user';
		
			
		if($componentManagerModel->save(false)){
			
			return true;
		}
	}
	
	public function reQueueEachChildFolder(){
		$folder = ConsoleFolder::findOne($this->folderId);
		$subFolders = $folder->subFolders;
		if(empty($subFolders)){
			return;
		} else{
			foreach($subFolders as $folder){
				if($folder->private_folder == 0 ){
					$queue = new Queue();
				 $queue->push(new FolderUsersQueue([
					'userId' => $this->userId,
					'folderId' => $folder->id,
					'type' => 'folder',
				]));
				}
			}
			return;
		}
	}
	
	
}