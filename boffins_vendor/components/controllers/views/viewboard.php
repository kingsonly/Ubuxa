<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<style>

.sidenav {
    height: 100vh;
    position: fixed;
    z-index: 10000;
    width: 0;
    top: 0;
    left: 0;
    background-color: #f8f6f6;
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
.noscroll{
    overflow-y: hidden;
}
 .content-wrapperz {
  width: 320px;
  /*margin: 0 auto;*/
}

.card-loader {
  background-color: #fff;
  padding: 8px;
  position: relative;
  border-radius: 2px;
  margin-bottom: 0;
  height: 200px;
  overflow: hidden;
}
.card-loader:only-child {
  margin-top: 0;
}
.card-loader:before {
  content: '';
  height: 110px;
  display: block;
  background-color: #ededed;
}
.card-loader:after {
  content: '';
  background-color: #333;
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  animation-duration: 0.86s;
  animation-iteration-count: infinite;
  animation-name: loader-animate;
  animation-timing-function: linear;
  background: -webkit-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.6) 30%, rgba(255, 255, 255, 0) 81%);
  background: -o-linear-gradient(left, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.6) 30%, rgba(255, 255, 255, 0) 81%);
  background: linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.6) 30%, rgba(255, 255, 255, 0) 81%);
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00ffffff', endColorstr='#00ffffff',GradientType=1 );
}
.second-one{
  margin-top: -80px;
}
.first-one{
  margin-top: 10px;
}
@keyframes loader-animate {
  0% {
    transform: translate3d(-100%, 0, 0);
  }
  100% {
    transform: translate3d(100%, 0, 0);
  }
}
.content-loader{
    display: none;
}
</style>


<div id="mySidenav" class="sidenav">
    <div class="content-loader">
      <div class="col-sm-12"> 
        <div class="col-sm-3">
          <div class="content-wrapperz first-one">
            <div class="card-loader card-loader--tabs"></div>
          </div>

          <div class="content-wrapperz second-one">
            <div class="card-loader card-loader--tabs"></div>
          </div>

          <div class="content-wrapperz second-one">
            <div class="card-loader card-loader--tabs"></div>
          </div>

          <div class="content-wrapperz second-one">
            <div class="card-loader card-loader--tabs"></div>
          </div>
        </div>

        <div class="col-sm-3">
          <div class="content-wrapperz first-one">
            <div class="card-loader card-loader--tabs"></div>
          </div>

          <div class="content-wrapperz second-one">
            <div class="card-loader card-loader--tabs"></div>
          </div>
        </div>

        <div class="col-sm-3">
          <div class="content-wrapperz first-one">
            <div class="card-loader card-loader--tabs"></div>
          </div>

          <div class="content-wrapperz second-one">
            <div class="card-loader card-loader--tabs"></div>
          </div>

          <div class="content-wrapperz second-one">
            <div class="card-loader card-loader--tabs"></div>
          </div>

          <div class="content-wrapperz second-one">
            <div class="card-loader card-loader--tabs"></div>
          </div>
        </div>

        <div class="col-sm-3">
          <div class="content-wrapperz first-one">
            <div class="card-loader card-loader--tabs"></div>
          </div>

          <div class="content-wrapperz second-one">
            <div class="card-loader card-loader--tabs"></div>
          </div>

          <div class="content-wrapperz second-one">
            <div class="card-loader card-loader--tabs"></div>
          </div>

          <div class="content-wrapperz second-one">
            <div class="card-loader card-loader--tabs"></div>
          </div>

          <div class="content-wrapperz second-one">
            <div class="card-loader card-loader--tabs"></div>
          </div>
        </div>
      </div>
    </div>
    <a class="closebtn kanban-board-app">&times;</a>
    
</div>

<div class="board-open">
    <span class="open-board"><i class="fa fa-tasks iconz"></i>View Task Board</span>
</div>

<?
$boardUrlz = Url::to(['task/board']);
$viewBoard = <<<JS


    $('.board-open').on('click',function(){
        var folderId = $('.board-specfic').attr('data-folderId');
        $(this).addClass('board-opened');
        $(this).removeClass('board-closed');
        $('#mySidenav').css({'width':'100%'})
        $('body').toggleClass('noscroll')
        $('.content-loader').show();
        setTimeout(function(){  
            $.ajax({
                url: '$boardUrlz'+'&folderIds='+folderId,
                success: function(data) {
                  $('.sidenav').html(data);
                },
                complete: function(){
                    $('.content-loader').fadeOut();
                 }
            });
        }, 700);
    });

$('.closebtn').click(function(){
  $('.board-open').removeClass('board-opened');
  $('.board-open').addClass('board-closed');
  $('#mySidenav').css({'width':'0'})
  $('body').toggleClass('noscroll')
});
JS;
$this->registerJs($viewBoard);
?>

