<?php
	use frontend\assets\AppAsset;
	AppAsset::register($this);
?>
<style>
	ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
}
.drag-container {
  max-width: 1000px;
  margin: 20px auto;
}
.drag-list {
  display: flex;
  align-items: flex-start;
}
@media (max-width: 690px) {
  .drag-list {
    display: block;
  }
}
.drag-column {
  flex: 1;
  margin: 0 10px;
  position: relative;
  background: rgba(0, 0, 0, 0.2);
  overflow: hidden;
  border-radius: 4px;
}
@media (max-width: 690px) {
  .drag-column {
    margin-bottom: 30px;
  }
}
.drag-column h2 {
  font-size: 1.2rem;
  margin: 0;
  text-transform: uppercase;
  font-weight: 600;
}
.drag-column-on-hold .drag-column-header, .drag-column-on-hold .is-moved, .drag-column-on-hold .drag-options {
  background: #fb7d44;
}
.drag-column-in-progress .drag-column-header, .drag-column-in-progress .is-moved, .drag-column-in-progress .drag-options {
  background: #2a92bf;
}
.drag-column-needs-review .drag-column-header, .drag-column-needs-review .is-moved, .drag-column-needs-review .drag-options {
  background: #f4ce46;
}
.drag-column-approved .drag-column-header, .drag-column-approved .is-moved, .drag-column-approved .drag-options {
  background: #00b961;
}
.drag-column-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px;
}
.drag-inner-list {
  min-height: 50px;
}
.drag-item {
  margin: 10px;
  height: 100px;
  background: #FAFAFA;
  transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
  cursor: -webkit-grab;
  cursor: grab;
  border-radius: 7px;
  box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1);
  position: relative;
}
.drag-item.is-moving {
  transform: scale(1.5);
  background: rgba(0, 0, 0, 0.8);
  cursor: -webkit-grabbing; 
  cursor: grabbing;
}
.drag-header-more {
  cursor: pointer;

}
.drag-options {
  position: absolute;
  top: 44px;
  left: 0;
  width: 100%;
  height: 100%;
  padding: 10px;
  transform: translateX(100%);
  opacity: 0;
  transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
}
.drag-options.active {
  transform: translateX(0);
  opacity: 1;
  z-index: 99;
}
.drag-options-label {
  display: block;
  margin: 0 0 5px 0;
}
.drag-options-label input {
  opacity: 0.6;
}
.drag-options-label span {
  display: inline-block;
  font-size: 0.9rem;
  font-weight: 400;
  margin-left: 5px;
}
/* Dragula CSS  */
.gu-mirror {
  position: fixed !important;
  margin: 0 !important;
  z-index: 9999 !important;
  opacity: 0.8;
  list-style-type: none;
}
.gu-hide {
  display: none !important;
}
.gu-unselectable {
  -webkit-user-select: none !important;
  -moz-user-select: none !important;
  -ms-user-select: none !important;
  user-select: none !important;
}
.gu-transit {
  opacity: 0.2;
}
/* Demo info */
.task-head {
  text-align: center;
}
.bottom-content {
	display: none;
	position: absolute;
    bottom: 0;
    left: 5px;
}

.drag-item:hover .bottom-content{
    display: block;
}

.icons {
	width: 43px;
}

.modal-content {
	background-color: #ebeef0 !important;
}

</style>

<section class="task-head">
	<h1>Task Board</h1>
</section>

<div class="drag-container">
	<ul class="drag-list">
		<li class="drag-column drag-column-on-hold">
			<span class="drag-column-header">
				<h2>TO DO</h2>
				<svg class="drag-header-more" data-target="options1" fill="#FFFFFF" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/</svg>
			</span>
				
			<div class="drag-options" id="options1"></div>
			
			<ul class="drag-inner-list" id="1">
				<li class="drag-item">
					<div class="bottom-content">
						<a href='#'><i class="fa fa-bell icons" aria-hidden="true"></i></a>
						<a href='#'><i class="fa fa-user-plus icons" aria-hidden="true"></i></a>
						<a href='#'><i class="fa fa-tags icons" aria-hidden="true"></i></a>
						<a href='#'><i class="fa fa-trash" aria-hidden="true"></i></a>
					</div>
				</li>
				<li class="drag-item"></li>
			</ul>
		</li>
		<li class="drag-column drag-column-in-progress">
			<span class="drag-column-header">
				<h2>In Progress</h2>
				<svg class="drag-header-more" data-target="options2" fill="#FFFFFF" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/</svg>
			</span>
			<div class="drag-options" id="options2"></div>
			<ul class="drag-inner-list" id="2">
				<li class="drag-item"></li>
				<li class="drag-item"></li>
				<li class="drag-item"></li>
			</ul>
		</li>
		<li class="drag-column drag-column-needs-review">
			<span class="drag-column-header">
				<h2>ON HOLD</h2>
				<svg data-target="options3" class="drag-header-more" fill="#FFFFFF" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/</svg>
			</span>
			<div class="drag-options" id="options3"></div>
			<ul class="drag-inner-list" id="3">
				<li class="drag-item"></li>
				<li class="drag-item"></li>
				<li class="drag-item"></li>
				<li class="drag-item"></li>
			</ul>
		</li>
		<li class="drag-column drag-column-approved">
			<span class="drag-column-header">
				<h2>DONE</h2>
				<svg data-target="options4" class="drag-header-more" fill="#FFFFFF" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/</svg>
			</span>
			<div class="drag-options" id="options4"></div>
			<ul class="drag-inner-list" id="4">
				<li class="drag-item"></li>
				<li class="drag-item"></li>
			</ul>
		</li>
	</ul>
</div>

<?php 
$board = <<<JS

    dragula([
    document.getElementById('1'),
    document.getElementById('2'),
    document.getElementById('3'),
    document.getElementById('4'),
    document.getElementById('5')
])

.on('drag', function(el) {
    
    // add 'is-moving' class to element being dragged
    el.classList.add('is-moving');
    console.log('moving');
})





.on('dragend', function(el) {
    
    // remove 'is-moving' class from element after dragging has stopped
    el.classList.remove('is-moving');
    console.log("done!");
    
    // add the 'is-moved' class for 600ms then remove it
    window.setTimeout(function() {
        el.classList.add('is-moved');
        window.setTimeout(function() {
            el.classList.remove('is-moved');
        }, 600);
    }, 100);
});


var createOptions = (function() {
    var dragOptions = document.querySelectorAll('.drag-options');
    
    // these strings are used for the checkbox labels
    var options = ['Research', 'Strategy', 'Inspiration', 'Execution'];
    
    // create the checkbox and labels here, just to keep the html clean. append the <label> to '.drag-options'
    function create() {
        for (var i = 0; i < dragOptions.length; i++) {

            options.forEach(function(item) {
                var checkbox = document.createElement('input');
                var label = document.createElement('label');
                var span = document.createElement('span');
                checkbox.setAttribute('type', 'checkbox');
                span.innerHTML = item;
                label.appendChild(span);
                label.insertBefore(checkbox, label.firstChild);
                label.classList.add('drag-options-label');
                dragOptions[i].appendChild(label);
            });

        }
    }
    
    return {
        create: create
    }
    
    
}());

var showOptions = (function () {
    
    // the 3 dot icon
    var more = document.querySelectorAll('.drag-header-more');
    
    function show() {
        // show 'drag-options' div when the more icon is clicked
        var target = this.getAttribute('data-target');
        var options = document.getElementById(target);
        options.classList.toggle('active');
    }
    
    
    function init() {
        for (i = 0; i < more.length; i++) {
            more[i].addEventListener('click', show, false);
        }
    }
    
    return {
        init: init
    }
}());

createOptions.create();
showOptions.init();

JS;
 
$this->registerJs($board);
?>
