<?php
namespace frontend\tests\unit\models;

use Yii;
use frontend\models\Folder;

class FolderForm extends \Codeception\Test\Unit
{
    public function createFolder()
    {
        $model = new Folder();

        $model->attributes = [
            'title' => 'Test Folder',
        ];
        $this->tester->haveRecord('frontend/model/folder', ['title' => 'Test Folder']);
        $this->tester->seeRecord('frontend/model/folder', ['title' => 'Test Folder']);
    }
}