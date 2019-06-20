<?php
use frontend\assets\AppAsset;
?>
<style type="text/css">
.infos-first{
	background-color: transparent !important;
	padding-left: 0px !important;
	padding-right: 0px !important;
}
.folderdetlss{
	background-color: transparent !important;
	padding-left: 0px !important;
	padding-right: 0px !important;
	background: #fff !important;
	box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1) !important;
}
.active-info {
	padding-left: 15px;
	padding-right: 15px;
	overflow:hidden;
}
.act-header {
	font-family: calibri;
	font-size: 19px;
	padding-top: 10px;
}
.box-content-activities {
	height: 50px;
	padding-top: 10px;
	font-style: italic;
    font-weight: bold;
    font-size: 15px;	
}
.green-border {
	border-bottom: 5px solid green;
}
.activedetls{
	padding-right: 0px !important;
	padding-left: 6px !important;
}
.info-1 {
	background-color: #fff;
}
.box-content-active {
	height: 92px;
	box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1);
}


 .activity-feed {
   list-style-type: none;
   padding: 0;
   margin: 50px 50px 50px 60px;
}
 .activity-feed .feed-item {
   position: relative;
   min-height: 60px;
   margin-bottom: 25px;
   padding-left: 30px;
   border-left: 2px solid #ddd;
}
 .activity-feed .feed-item:last-child {
   border-color: transparent;
}
 .activity-feed .feed-item:before {
   content: attr(data-time);
   display: flex;
   width: 100px;
   position: absolute;
   text-align: center;
   justify-content: center;
   align-items: center;
   left: -50px;
   top: -22px;
   font-size: 12px;
   color: #999;
}
 .activity-feed .feed-item::after {
   content: attr(data-content);
   display: flex;
   justify-content: center;
   align-items: center;
   position: absolute;
   top: 0;
   left: -21px;
   width: 40px;
   height: 40px;
   font: normal normal normal 14px/1 FontAwesome;
   font-size: inherit;
   text-rendering: auto;
   -webkit-font-smoothing: antialiased;
   -moz-osx-font-smoothing: grayscale;
   border-radius: 50%;
   color: white;
   background-color: #ddd;
}
 .activity-feed .feed-item section {
   background-color: white;
   padding: 10px 15px;
   border-radius: 4px;
   border: 1px solid #f0f0f0;
}
 .activity-feed .feed-item section:hover {
   box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
   transition: all 0.3s cubic-bezier(.25,.8,.25,1);
}
 .activity-feed .feed-item section label {
   display: block;
   cursor: pointer;
}
 .active-section input[type="checkbox"] {
   display: none;
}
 .active-section input[type="checkbox"]:checked ~ label:after {
   transform: rotate(45deg);
   color: tomato;
}
 .active-section input[type="checkbox"]:checked ~ .content {
   max-height: 1000px;
   border-top: 1px solid #f0f0f0;
   padding-top: 10px;
   margin-top: 10px;
   padding: 0 25px;
   transition: max-height .25s ease-in;
}
 .activity-content {
   max-height: 0;
   overflow: hidden;
}
 .activity-content blockquote {
   position: relative;
}
 .activity-content blockquote:before {
   content: '';
   position: absolute;
   left: -25px;
   top: 0;
   height: 100%;
   border-left: 2px solid #fcd000;
}
 [data-color=red]:after {
   background-color: #ff3c41 !important;
}
 [data-color=blue]:after {
   background-color: #2cb5e8 !important;
}
 [data-color=green]:after {
   background-color: #47cf73 !important;
}
 [data-color=yellow]:after {
   background-color: #fcd000 !important;
}
#activity1{
	z-index: 10000003;
	position: absolute;
	background-color: rgb(255, 255, 255);
    height: 400px;
    /*overflow: hidden;*/
}
@keyframes movingTopToBottom {
  0% {
    top: -15px;
  }
  95% {
    top: 150px;
  }
  100% {
    top: 165px;
  }
}

#divTAReviews {
  animation: movingTopToBottom 5s linear infinite;
  position: relative;
  background: lightblue;
  display: inline-block;
  padding: 10px;
}
.activity {
  border-left: solid 2px #7ED321;
  font: 12px/1.2 'Lucida Grande', sans-serif;
  color: #2C2C2C;
  padding: 6px;
  position: relative;
}
.activity a {
  text-decoration: none;
}
.activity--subscriber {
  background: #EBEBEB;
  border-left: none;
  border-right: solid 2px #2176D3;
}
.activity--notice {
  background-color: #e1f7c9;
}
.activity--notice.activity--subscriber {
  background-color: #c9dff7;
}
.activity__time {
  font-size: 10px;
  font-weight: normal;
  display: block;
  margin-bottom: 3px;
  margin-top: -3px;
  color: #97e245;
}
.activity__time--subscriber {
  color: #4590e2;
}
.activity__avatar {
  border-radius: 3px;
  vertical-align: bottom;
  position: absolute;
}
.activity__avatar--subscriber {
  right: 6px;
}
.activity__message {
  min-height: 35px;
  padding: 6px;
  padding-left: 46px;
}
.activity__message p {
  padding: 3px 0;
  margin: 0;
}
.activity__message p + img {
  margin-top: 6px;
  margin-bottom: 3px;
}
.activity__message p:first-child {
  padding-top: 0;
}
.activity__message p:last-child {
  padding-bottom: 0;
}
.activity__message img {
  width: 100%;
  max-width: 100%;
}
.activity__message--subscriber {
  padding-left: 6px;
  padding-right: 46px;
  text-align: right;
}
.activity__message--full {
  min-height: initial;
  text-align: center;
  padding-left: 6px;
  font-weight: bold;
}
.activity__file-name {
  color: #7E7E7E;
  display: block;
  padding: 3px 0 0 5px;
  font-size: 10px;
}

.activity-list {
  background: #FDFDFD;
}

.file-icon {
  width: 75px;
  height: 100px;
  display: block;
  text-align: center;
  line-height: 100px;
  text-transform: uppercase;
  border-radius: 5px;
  font-weight: bold;
  text-decoration: none;
  background: #F1734C;
  color: #FFF;
  font-size: 16px;
}
.file-icon:hover {
  background-color: #ef6134;
}

/* not part of the activities module */
* {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

</style>

<div class="col-md-6">
	<div class="col-sm-12 col-xs-12 infos-first panel-group column-margin">
		<div class="col-sm-10 col-xs-8 folderdetlss ">
			<div class="active-info">
				<div class="act-header">Recent Activity</div>
				<div class="stream_activity">
					<div id="divTAReviewss">Review Text1</div>
				</div>
				
			</div>
			
			<div class="green-border"></div>
		</div>

		<div class="col-sm-2 col-xs-4 activedetls">
			<div class="info-1">
				<div class="box-content-active">
					<a data-toggle="collapse" href="#activity1">
					<h1  class="act_count" style="margin:0; text-align:center;color:red;">0</h1>
					<div class="active-text"> New Activity</div>
				    </a>
				</div>
			</div>
		</div>
		<div id="activity1" class="col-sm-12 col-xs-12 panel-collapse collapse">
			<div class="fa fa-times activity-close" style="float: right; cursor: pointer;cursor: pointer;padding: 15px 10px;"></div>
			<div class="activity-list" style="margin-top:50px">
  
  <div class="activity">
    <img class="activity__avatar" width="35" height="35" src="https://s3.amazonaws.com/uifaces/faces/twitter/brad_frost/128.jpg">
    <div class="activity__message">
      <p>Hey there, welcome to this ace messaging thing?</p>
    </div>
  </div>
    
  <div class="activity activity--subscriber">
    <img class="activity__avatar activity__avatar--subscriber" width="35" height="35" src="https://s3.amazonaws.com/uifaces/faces/twitter/csswizardry/128.jpg">
    <div class="activity__message activity__message--subscriber">
      <p>Pretty rad yeah, I wonder what it can do other than messages...</p>
    </div>
  </div>
    
  <div class="activity">
    <img class="activity__avatar" width="35" height="35" src="https://s3.amazonaws.com/uifaces/faces/twitter/brad_frost/128.jpg">
    <div class="activity__message">
      <p>I think I've seen something like this before though.</p>
      <p>Where though, is anyone's guess.</p>
    </div>
  </div>
    
  <div class="activity">
    <img class="activity__avatar" width="35" height="35" src="https://s3.amazonaws.com/uifaces/faces/twitter/brad_frost/128.jpg">
    <div class="activity__message">
      <a href="#">
        <img src="http://images.nationalgeographic.com/wpf/media-live/photos/000/020/cache/yosemite-deep-valley_2013_600x450.jpg">
        <span class="activity__file-name">yosemite.jpg</span>
      </a>
    </div>
  </div>
      
  <div class="activity activity--subscriber">
    <img class="activity__avatar activity__avatar--subscriber" width="35" height="35" src="https://s3.amazonaws.com/uifaces/faces/twitter/csswizardry/128.jpg">
    <div class="activity__message activity__message--subscriber">
      <p>That looks like Yosemite!</p>
    </div>
  </div>
    
  <div class="activity">
    <img class="activity__avatar" width="35" height="35" src="https://s3.amazonaws.com/uifaces/faces/twitter/brad_frost/128.jpg">
    <div class="activity__message">
      <p>Sure is.</p>
    </div>
  </div>
    
  <div class="activity activity--notice">
    <div class="activity__message activity__message--full">
      <time class="activity__time">Last Tuesday at 9:31 AM</time>
      <p>Brad Forst offered the lesson</p>
    </div>
  </div>
  
  <div class="activity activity--notice activity--subscriber">
    <div class="activity__message activity__message--full">
      <time class="activity__time activity__time--subscriber">Last Tuesday at 9:45 AM</time>
      <p>Harry Roberts accepted the lesson</p>
    </div>
  </div>
  
  <div class="activity activity--subscriber">
    <img class="activity__avatar activity__avatar--subscriber" width="35" height="35" src="https://s3.amazonaws.com/uifaces/faces/twitter/csswizardry/128.jpg">
    <div class="activity__message activity__message--subscriber">
      <p>Right lesson time! Game faces on. Do you mind sending me that PDF over you were on about please?</p>
    </div>
  </div>
  
  <div class="activity">
    <img class="activity__avatar" width="35" height="35" src="https://s3.amazonaws.com/uifaces/faces/twitter/brad_frost/128.jpg">
    <div class="activity__message">
      <p>Yep, one sec</p>
    </div>
  </div>
  
  <div class="activity activity--subscriber">
    <img class="activity__avatar activity__avatar--subscriber" width="35" height="35" src="https://s3.amazonaws.com/uifaces/faces/twitter/csswizardry/128.jpg">
    <div class="activity__message activity__message--subscriber">
      <p>Come on, I don't have long!!</p>
      <img width="100" src="http://replygif.net/i/1129.gif">
      <p>Waiting...</p>
    </div>
  </div>
  
  <div class="activity">
    <img class="activity__avatar" width="35" height="35" src="https://s3.amazonaws.com/uifaces/faces/twitter/brad_frost/128.jpg">
    <div class="activity__message">
      <a href="">
        <div class="file-icon">
          .psd
        </div>
        <span class="activity__file-name">test.psd</span>
      </a>
    </div>
  </div>
      
</div>
</div>
		
	</div>
   						
</div>
<?php 
$activityJS = <<<activityJS

const ps = new PerfectScrollbar('#activity1', {
  wheelSpeed: 2,
  wheelPropagation: true,
  minScrollbarLength: 20
});
$('.activity-close').click(function(){
	$('#activity1').collapse('hide')
})

activityJS;
$this->registerJs($activityJS);
?>