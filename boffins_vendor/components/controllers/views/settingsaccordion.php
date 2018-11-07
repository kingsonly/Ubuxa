<?php
use boffins_vendor\components\controllers\ViewBoardWidget;
?>

<style>
 
/* -------------------------------- 
Main Components 
-------------------------------- */
.cd-accordss-menu {
    width: 100%;
    max-width: 360px;
    background: #3F51B5;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    margin: 25px auto 20px;
    margin-bottom: 0px;
}
.cd-accordss-menu .first-list {
  /* by defa.first-listt hide all sub menus */
  display: none;
}
.cd-accordss-menu .second-list {
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.cd-accordss-menu .accord-input {
  /* hide native checkbox */
  position: absolute;
  opacity: 0;
}
.has-children {
  list-style-type: none;
}
.second-list{
  border-bottom: 1px solid #6d6d6d;
}
.cd-accordss-menu .accord-label, .cd-accordss-menu a {
  display: block;
  padding: 18px 18px 18px 64px;
  background: #3F51B5;
  color: #ffffff;
  font-size: 1.6rem;
}
.no-touch .cd-accordss-menu .accord-label:hover, .no-touch .cd-accordss-menu a:hover {
  background: #52565d;
}
.cd-accordss-menu .accord-label::before, .cd-accordss-menu .accord-label::after, .cd-accordss-menu a::after {
  /* icons */
  content: '';
  display: inline-block;
  width: 16px;
  height: 16px;
  position: absolute;
  top: 50%;
  -webkit-transform: translateY(-50%);
  -moz-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  -o-transform: translateY(-50%);
  transform: translateY(-50%);
}
.cd-accordss-menu .accord-label {
  cursor: pointer;
  display: block;
  padding: 15px 15px 15px 42px;
  color: #fff;
  font-size: 14px;
  font-weight: 700;
  border-bottom: 1px solid #aba6a6;
  position: relative;
  -webkit-transition: all 0.4s ease;
  -o-transition: all 0.4s ease;
  transition: all 0.4s ease;
  border-radius: 3px;
}
.accord-label {
  margin-bottom: 0px;
}
.cd-accordss-menu .accord-label::before, .cd-accordss-menu .accord-label::after {
  background-image: url(../img/cd-icons.svg);
  background-repeat: no-repeat;
}
.cd-accordss-menu .accord-label::before {
  /* arrow icon */
  left: 18px;
  background-position: 0 0;
  -webkit-transform: translateY(-50%) rotate(-90deg);
  -moz-transform: translateY(-50%) rotate(-90deg);
  -ms-transform: translateY(-50%) rotate(-90deg);
  -o-transform: translateY(-50%) rotate(-90deg);
  transform: translateY(-50%) rotate(-90deg);
}
.cd-accordss-menu .accord-label::after {
  /* folder icons */
  left: 41px;
  background-position: -16px 0;
}
.cd-accordss-menu a::after {
  /* image icon */
  left: 36px;
  background: url(../img/cd-icons.svg) no-repeat -48px 0;
}
.cd-accordss-menu .accord-input:checked + .accord-label::before {
  /* rotate arrow */
  -webkit-transform: translateY(-50%);
  -moz-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  -o-transform: translateY(-50%);
  transform: translateY(-50%);
}
.cd-accordss-menu .accord-input:checked + .accord-label::after {
  /* show open folder icon if item is checked */
  background-position: -32px 0;
}
.cd-accordss-menu .accord-input:checked + .accord-label + .first-list,
.cd-accordss-menu .accord-input:checked + .accord-label:nth-of-type(n) + .first-list {
  /* use label:nth-of-type(n) to fix a bug on safari (<= 8.0.8) with m.first-listtiple adjacent-sibling selectors*/
  /* show children when item is checked */
  display: block;
}
.cd-accordss-menu .first-list .accord-label,
.cd-accordss-menu .first-list a {
  padding-left: 60px;
  background: #444359;
  font-size: 14px;
  color: #d9d9d9;
  border-radius: unset;
}
.no-touch .cd-accordss-menu .first-list .accord-label:hover, .no-touch
.cd-accordss-menu .first-list a:hover {
  background: #3c3f45;
}
.cd-accordss-menu > li:last-of-type > .accord-label,
.cd-accordss-menu > li:last-of-type > a,
.cd-accordss-menu > li > .first-list > li:last-of-type .accord-label,
.cd-accordss-menu > li > .first-list > li:last-of-type a {
  box-shadow: none;
}
.cd-accordss-menu .first-list .accord-label::before {
  left: 36px;
}
.cd-accordss-menu .first-list .accord-label::after,
.cd-accordss-menu .first-list a::after {
  left: 59px;
}
.cd-accordss-menu .first-list .first-list .accord-label,
.cd-accordss-menu .first-list .first-list a {
  padding-left: 100px;
}
.cd-accordss-menu .first-list .first-list .accord-label::before {
  left: 54px;
}
.cd-accordss-menu .first-list .first-list .accord-label::after,
.cd-accordss-menu .first-list .first-list a::after {
  left: 77px;
}
.cd-accordss-menu .first-list .first-list .first-list .accord-label,
.cd-accordss-menu .first-list .first-list .first-list a {
  padding-left: 118px;
}
.cd-accordss-menu .first-list .first-list .first-list .accord-label::before {
  left: 72px;
}
.cd-accordss-menu .first-list .first-list .first-list .accord-label::after,
.cd-accordss-menu .first-list .first-list .first-list a::after {
  left: 95px;
}

.cd-accordss-menu.animated .accord-label::before {
  /* this class is used if you're using jquery to animate the accordss */
  -webkit-transition: -webkit-transform 0.3s;
  -moz-transition: -moz-transform 0.3s;
  transition: transform 0.3s;
}
.iconz {
    position: absolute;
    top: 16px;
    left: 12px;
    font-size: 18px;
    color: #fff !important;
    -webkit-transition: all 0.4s ease;
    -o-transition: all 0.4s ease;
    transition: all 0.4s ease;
}
.iconz-down {
    right: 12px;
    left: auto;
    font-size: 16px;
    position: absolute;
    top: 16px;
    color: #fff !important;
    transition: all 0.4s ease;
}
.iconzz {
  position: absolute;
  left: 50px;
  font-size: 18px;
  color: #fff !important;
  -webkit-transition: all 0.4s ease;
  -o-transition: all 0.4s ease;
  transition: all 0.4s ease;
}
</style>

  <ul class="cd-accordss-menu animated">
    <li class="has-children">

      <input type="checkbox" name="group-4" class="accord-input" id="group-4">
      <label class="accord-label" for="group-4"><i class="fa fa-cog iconz iconz"></i>Settings<i class="fa fa-chevron-down iconz-down"></i></label>

          <ul class="first-list">
            <li class="has-children">
              Test          
            </li>      
          </ul>
    </li>
  </ul>

<?php
$accordss = <<<JS
$(document).ready(function(){
  var accordsssMenu = $('.cd-accordss-menu');

  if( accordsssMenu.length > 0 ) {
    
    accordsssMenu.each(function(){
      var accordss = $(this);
      //detect change in the input[type="checkbox"] value
      accordss.on('change', 'input[type="checkbox"]', function(){
        var checkbox = $(this);
        console.log(checkbox.prop('checked'));
        ( checkbox.prop('checked') ) ? checkbox.siblings('ul').attr('style', 'display:none;').slideDown(300) : checkbox.siblings('ul').attr('style', 'display:block;').slideUp(300);
      });
    });
  }
});
JS;
$this->registerJs($accordss);
?>