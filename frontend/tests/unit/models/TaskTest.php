<?php
namespace frontend\tests\unit\models;

use Yii;
use frontend\models\Task;

class TaskTest extends \Codeception\Test\Unit
{
    public function create()
    {
        $model = new Task();

        $model->attributes = [
            'title' => 'Tester',
        ];

        expect_that($model->save());

        expect($model->title)->equals('Tester');
    }
}
