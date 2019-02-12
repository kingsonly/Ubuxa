<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use frontend\models\TaskAssignedUser;
use yii\widgets\Pjax;


?>
<style>
  .X{
  max-width: 500px;
  margin: auto;
  font-family: 'Roboto', sans-serif;
}
.search-field{
  background-position: 10px 12px;
  background-repeat: no-repeat; 
  width: 100%; 
  font-size: 17px; 
  padding: 12px 20px 12px 40px;
  margin-top: 10px;
  margin-bottom: 20px; 
  border: none;
  border-radius: 2px;
  box-shadow: 0 2px 2px 0 rgba(0,0,0,0.16), 0 0 0 1px rgba(0,0,0,0.08);
}
.search-field:focus{outline: none;}
.search-field:hover, .search-field:focus{
  box-shadow: 0 3px 8px 0 rgba(0,0,0, 0.2), 0 0 0 1px rgba(0,0,0, 0.08);
}
.list-body {
    list-style-type: none;
    padding: 0;
    margin: 0;
}
.list-name {
    border-bottom: 1px solid #ccc
    margin-top: -1px; 
    padding: 12px; 
    text-decoration: none;
    font-size: 18px; 
    color: black; 
    display: block;
    background-color: #fff;
}
.list-name {
    border-bottom: 1px solid #ccc;
    cursor: pointer;
    border-radius: 2px 
}

.list-name:hover {
  background-color: #ccc;
}

.bott {
      height: 200px;
    overflow: scroll;
}
.asignee-head {
  font-size: 20px;
  text-align: center;
  border-bottom: 1px solid #ccc;
  padding-bottom: 5px;
}

.boxes {
  margin: auto;
  padding: 4px;
}

/*Checkboxes styles*/
input[type="checkbox"] { display: none; }

.assign-input + .assign-name {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 20px;
  font: 15px/20px 'Open Sans', Arial, sans-serif;
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
}

.assign-input + .assign-name:last-child { margin-bottom: 0; }

.assign-input + .assign-name:before {
  content: '';
  display: block;
  width: 20px;
  height: 20px;
  border: 2px solid #6cc0e5;
  position: absolute;
  border-radius: 4px;
  left: 0;
  top: 0;
  -webkit-transition: all .12s, border-color .08s;
  transition: all .12s, border-color .08s;
}

.assign-input:checked + .assign-name:before {
  width: 10px;
  top: -5px;
  left: 5px;
  border-radius: 0;
  border-top-color: transparent;
  border-left-color: transparent;
  -webkit-transform: rotate(45deg);
  transform: rotate(45deg);
}




/*Info:
iS = input Search
fS = Function Search
sU = Search Ul
lH = li Header
*/

</style>

<div class="X" id="cover<?=$taskid.$assigneeId; ?>">
  <div class="asignee-head"><span class="span-header">Assignees</span></div>
<input type="search" id="iS<?= $taskid.$assigneeId ?>"  placeholder="Search names..." class="search-field">
<div class="bott">
<ul id="list-body" class="list-bodytest ghpd">
    <?php 
        $id = 1;
        foreach ($users as $key => $user) { 
          $exists = TaskAssignedUser::find()->where(['task_id' => $taskid, 'user_id' => $user->id, 'status' => 1])->exists();
          ?>

    <li class="useritems" id="useritems<?= $id.'-'.$taskid; ?>">
            <a class="list-name" data-userid="<?= $user->id;?>" id="list<?= $id; ?>">
        <div class="boxes" id="box<?= $id; ?>">
          <div class="boxes" id="box<?= $id; ?>">
            <input type="checkbox" id="box-<?= $id.'-'.$taskid.$assigneeId; ?>" data-userid="<?= $user->id; ?>" data-taskid="<?= $taskid; ?>" class="assign-input"<?= $exists ? 'checked': '';?> >
            <label for="box-<?= $id.'-'.$taskid.$assigneeId; ?>" class="assign-name"><?= $user->fullName; ?></label>
        </div>
        </div>
      </a>
      
    </li>
    <?php $id++;  } ?>
</ul>
</div>

</div>

<?php
$assignUrl = Url::to(['task/assignee']);
$assignee = <<<JS


  $('.list-bodytest').on('click', function(e) {
      if($(this).hasClass('ghpd')) {
        e.stopPropagation();
      }
  });


$(".assign-input").change(function(event) {
    var user;
    var taskid;
    user = $(this).data('userid');
    taskid = $(this).data('taskid');
    console.log(user, taskid)
    _AddUser(user, taskid);        
});

$(document).ready(function(){
  $(".search-field").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#list-body li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

function _AddUser(user,taskid){
          $.ajax({
              url: '$assignUrl',
              type: 'POST', 
              data: {
                  user_id: user,
                  task_id: taskid, 
                },
              success: function(res, sec){
                    toastr.success('Completed');
                    $.pjax.reload({container:"#task-list-refresh"});
                    $.pjax.reload({container:"#kanban-refresh",async: false});
                    //$.pjax.reload({container:"#task-modal-refresh",async: false});
                   console.log('Completed');
              },
              error: function(res, sec){
                  console.log('Something went wrong');
              }
          });
}

JS;
 
$this->registerJs($assignee, $this::POS_END);
?>