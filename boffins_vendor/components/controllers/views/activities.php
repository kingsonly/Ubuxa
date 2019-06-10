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
			<ol class="activity-feed">
  <li class="feed-item" data-content="&#xf00c;" data-time="3 hours ago" data-color="green">
    <section class="active-section">
      <input type="checkbox" id="expand_1" name="expand_1" />
      <label for="expand_1">
        <b>Etiam feugiat</b> dolor nec molestie <b>posuere.</b>
      </label>
      <main class="activity-content">
        <blockquote>Duis iaculis commodo condimentum. Donec quis felis libero. Nunc feugiat nisi ut ullamcorper congue. Ut tempus egestas mauris et scelerisque. Sed tincidunt ante ligula, eget pharetra mi pretium eget. Fusce tincidunt, elit blandit semper sollicitudin, sapien lectus lobortis quam, ac bibendum lectus risus quis lectus.</blockquote>
        <blockquote>Duis iaculis commodo condimentum. Donec quis felis libero. Nunc feugiat nisi ut ullamcorper congue. Ut tempus egestas mauris et scelerisque. Sed tincidunt ante ligula, eget pharetra mi pretium eget. Fusce tincidunt, elit blandit semper sollicitudin, sapien lectus lobortis quam, ac bibendum lectus risus quis lectus.</blockquote>
      </main>
    </section>
  </li>
  <li class="feed-item" data-content="&#xf27b;" data-time="3 hours ago" data-color="blue">
    <section class="active-section">
      <input type="checkbox" id="expand_2" name="expand_2" />
      <label for="expand_2">
        <b>Aliquam</b> non diam <b>consectetur.</b>
      </label>
      <main class="activity-content">
        <p>Duis iaculis commodo condimentum. Donec quis felis libero. Nunc feugiat nisi ut ullamcorper congue.</p>
        <p>Ut tempus egestas mauris et scelerisque. Sed tincidunt ante ligula, eget pharetra mi pretium eget. Fusce tincidunt, elit blandit semper sollicitudin, sapien lectus lobortis quam, ac bibendum lectus risus quis lectus.</p>
      </main>
    </section>
  </li>
  <li class="feed-item" data-content="&#xf004;" data-time="3 hours ago" data-color="red">
    <section class="active-section">
      <input type="checkbox" id="expand_3" name="expand_3" />
      <label for="expand_3">
        <b>Nullam</b> mollis massa ut <b>egestas viverra.</b>
      </label>
      <main class="activity-content">
        <img src="http://i0.kym-cdn.com/photos/images/facebook/000/232/114/e39.png">
      </main>
    </section>
  </li>
  <li class="feed-item" data-content="&#xf00c;" data-time="3 hours ago" data-color="green">
    <section class="active-section">
      <label for="expand_4">
        <b>Etiam feugiat</b> dolor nec molestie <b>posuere.</b>
        <br>
        Donec quis felis libero.
        <b>Etiam feugiat</b> dolor nec molestie <b>posuere.</b>
        <br>
        Donec quis felis libero.
        <b>Etiam feugiat</b> dolor nec molestie <b>posuere.</b>
        <br>
        Donec quis felis libero.
      </label>
    </section>
  </li>
  <li class="feed-item" data-content="&#xf0e7;" data-time="3 hours ago" data-color="yellow">
    <section class="active-section">
      <input type="checkbox" id="expand_5" name="expand_5" />
      <label for="expand_5">
        <b>Pellentesque accumsan</b> ligula a tincidunt <b>venenatis.</b>
      </label>
      <main class="activity-content">
        <h1>BOOM!</h1>
      </main>
    </section>
  </li>
</ol>
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