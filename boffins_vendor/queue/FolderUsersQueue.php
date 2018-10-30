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
	
    public function execute($queue){
        $this->addNewUser();
		
    }
	
	public function addNewUser($userId = '', $folderId = '')
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
				]));
				}
			}
			return;
		}
	}
	
	
}