
<style>

.sidenav {
    height: 100vh;
    width: 0;
    position: fixed;
    z-index: 10000;
    top: 0;
    left: 0;
    background-color: #f8f6f6;
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 20px;
    overflow: hidden;
    margin: auto;
}

.sidenav .closebtn {
    text-decoration: none;
    font-size: 25px;
    color: #818181;
    display: block;
    transition: 0.3s;
    border-radius: 50%;
    cursor: pointer;
}

.sidenav .closebtn:hover{
    color: #000;
}

.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
}
.open-board{
    cursor: pointer;
    display: block;
    padding: 0px 0px 0px 42px;
    font-size: 14px;
    font-weight: 700;
    border-bottom: 1px solid #aba6a6;
    position: relative;
    -webkit-transition: all 0.4s ease;
    -o-transition: all 0.4s ease;
    transition: all 0.4s ease;
    border-radius: 3px;
    padding-bottom: 15px;
    padding-top: 15px;
    color: #fff;
}


</style>


<div id="mySidenav" class="sidenav">
  <div class="close-kanban">
    <a class="closebtn">&times;</a>
      <?php if (isset($this->blocks['kanban'])){ ?>
              <?= $this->blocks['kanban'] ?>
      <?php }?>
  </div>
</div>

<div class="board-open">
    <span class="open-board"><i class="fa fa-tasks iconz"></i>View Board</span>
</div>

<?
$viewBoard = <<<JS


    $('.board-open').click(function(){
        $(this).addClass('board-opened');
        $(this).removeClass('board-closed');
        $('#mySidenav').css({'width':'100%'})
    });

    $('.closebtn').click(function(){
        setTimeout(function(){
            $.pjax.reload({container:"#task-list-refresh",async: false});
            }, 550);
        $('.board-open').removeClass('board-opened');
        $('.board-open').addClass('board-closed');
        $('#mySidenav').css({'width':'0'})
    });


JS;
$this->registerJs($viewBoard);
?>

