
<style>

.sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 10000;
    top: 0;
    left: 0;
    background-color: rgb(214, 240, 255);
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 20px;
    overflow: scroll;
}

.sidenav .closebtn {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 25px;
    color: #818181;
    display: block;
    transition: 0.3s;

}

.sidenav .closebtn:hover{
    color: #f1f1f1;
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
    background: #fff;
}

</style>


<div id="mySidenav" class="sidenav">
  <div class="close-kanban">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <?php if (isset($this->blocks['kanban'])){ ?>
              <?= $this->blocks['kanban'] ?>
      <?php }?>
  </div>
</div>


<span class="open-board" onclick="openNav()"><i class="fa fa-tasks iconz"></i>View Board</span>


<?
$viewBoard = <<<JS
  function openNav() {
    document.getElementById("mySidenav").style.width = "100%";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
JS;
$this->registerJs($viewBoard, $this::POS_END);
?>

