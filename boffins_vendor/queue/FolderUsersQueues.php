<?
namespace boffins_vendor\queue;
use frontend\models\Folder;
use frontend\models\FolderManager;
use yii\base\BaseObject;


class FolderUsersQueues extends BaseObject implements \yii\queue\JobInterface
{   
	public $userId;
	public $folderId;
    public function execute($queue){
        $this->addNewUser();
    }
	
	private function addNewUser(){
		$folderManagerModel = new FolderManager();
		$folderModel = new Folder();
		$folderManagerModel -> user_id = $this->userId;
		$folderManagerModel -> folder_id = $this->folderId;
		$folderManagerModel -> role = 'user';
		$folderManagerModel->save(false);
		//$folderManagerModel->save(false);
		
	}
	
	
}