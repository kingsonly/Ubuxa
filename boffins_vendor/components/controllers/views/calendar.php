<?php
    use yii\helpers\Url;
?>
<style>

.sidenav-calendar {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 10000;
    top: 0;
    left: 0;
    background-color: #f8f6f6;
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 20px;
    overflow: scroll;
    margin: auto;
}

.sidenav-calendar .closebtn-calendar {
    text-decoration: none;
    font-size: 25px;
    color: #818181;
    display: block;
    transition: 0.3s;
    border-radius: 50%;
    cursor: pointer;
}

.sidenav-calendar .closebtn-calendar:hover{
    color: #000;
}

.sidenav-calendar .closebtn-calendar {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
}
.open-calendar{
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


<div id="mysidenav-calendar-calendar" class="sidenav-calendar">
  <div class="close-calendar">
    <a class="closebtn-calendar">&times;</a>
    
  </div>
  <div class="main-calendar-container"></div>
</div>

<div class="calendar-open">
    <a href="<?=Url::to(['calendar/index','id'=>$folderId]);?>"><span class="open-calendar"><i class="fa fa-calendar iconz"></i>View Calendar</span></a>
</div>

<?
$viewBoard = <<<JS


   
JS;
$this->registerJs($viewBoard);
?>

