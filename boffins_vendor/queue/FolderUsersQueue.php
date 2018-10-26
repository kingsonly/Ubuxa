<?
namespace boffins_vendor\queue;
use frontend\models\UserDb;
use frontend\models\FolderManager;
use frontend\models\Folder;
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
		$folderManagerModel->user_id = $userId;
		$folderManagerModel->folder_id = $folderId;
		$folderManagerModel->role = 'user';
		
			
		if($folderManagerModel->save(false)){
			
			$this->reQueueEachChildFolder();
		}
	}
	
	private function checkFolderParentRelationship(){
		
	}
	
	public function reQueueEachChildFolder(){
		//$this->addNewUser(24, 34);
		//$folderModel = new Folder();
		//$fetchFolder = $folderModel->find()->where(['id' => 33])->one();
		
		$user = Folder::findOne(33);
		
		$this->smart = $user;
		var_dump($this->smart);
		if(empty($this->smart)){
			$queue = new Queue();
				 $queue->push(new FolderUsersQueue([
					'userId' => 24,
					'folderId' => 34,
				]));
			return;
			
		} else{
			$queue = new Queue();
				 $queue->push(new FolderUsersQueue([
					'userId' => 24,
					'folderId' => 34,
				]));
			return;
		}
	}
	
	
}