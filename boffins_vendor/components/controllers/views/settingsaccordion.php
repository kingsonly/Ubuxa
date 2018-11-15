<?php
use boffins_vendor\components\controllers\ViewBoardWidget;
use yii\helpers\Html;
use yii\helpers\Url;
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
.settings-container{
  overflow: scroll;
  visibility: hidden;
  width:300px;
  min-height:1px;
  background:#fff;
}
.settings-text{
    font-size: 36px;
    margin-left: 35px;
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
.tab-wrap {
  width: 90%;
  margin-left: 30px;
  position: relative;
  display: flex;
  box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1);
}
.first-tab {
  color: #3498db;
}
.second-tab {
  color: #9b59b6;
}
.third-tab {
  color: #e67e22;
}
.fourth-tab {
  color: #333;
}
input[type="radio"][name="tabs"] {
  position: absolute;
  z-index: -1;
}
input[type="radio"][name="tabs"]:checked + .tab-label-content .settings-tabz {
}
input[type="radio"][name="tabs"]:checked + .tab-label-content .tab-content {
  display: block;
}
input[type="radio"][name="tabs"]:nth-of-type(1):checked ~ .slide {
  left: calc((100% / 4) * 0);
  background: #3498db;
}
input[type="radio"][name="tabs"]:nth-of-type(2):checked ~ .slide {
  left: calc((100% / 4) * 1);
  background: #9b59b6;
}
input[type="radio"][name="tabs"]:nth-of-type(3):checked ~ .slide {
  left: calc((100% / 4) * 2);
  background: #e67e22;
}
input[type="radio"][name="tabs"]:nth-of-type(4):checked ~ .slide {
  left: calc((100% / 4) * 3);
  background: #333;
}
input[type="radio"][name="tabs"]:first-of-type:checked ~ .slide {
  left: 0;
}

.settings-tabz {
  cursor: pointer;
  color: #000;
  background-color: #fff;
  box-sizing: border-box;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  height: 56px;
  transition: color 0.2s ease;
  width: 100%;
}
.slide {
  background: #ffeb3b;
  width: calc(100% / 4);
  height: 4px;
  position: absolute;
  left: 0;
  top: calc(100% - 4px);
  transition: left 0.3s ease-out;
}
.tab-label-content {
  width: 100%;
}
.dates label {
    display: block;
    line-height: 1.2em;
    color: #636363;
    counter-increment: section;
    cursor: pointer;
    margin: .5em .5em .5em 0;
    padding: .4em .4em .4em 1.8em;
    border-radius: 5px;
    background: #fff;
    box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1);
}

.tab-label-content .tab-content {
  position: absolute;
  top: 80px;
  left: 16px;
  line-height: 130%;
  display: none;
}
@media screen and (max-width: 800px) {
  .tab-wrap {
    width: 80%;
    margin-left: 10%;
    top: -106px;
    box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1);
  }
}
.follow {
  width: 42px;
  height: 42px;
  border-radius: 50px;
  background: #03a9f4;
  display: block;
  margin: 300px auto 0;
  white-space: nowrap;
  padding: 13px;
  box-sizing: border-box;
  color: white;
  transition: all 0.2s ease;
  font-family: Roboto, sans-serif;
  text-decoration: none;
  box-shadow: 0 5px 6px 0 rgba(0, 0, 0, 0.2);
}
.follow i {
  margin-right: 20px;
  transition: margin-right 0.2s ease;
}
.follow:hover {
  width: 134px;
}
.follow:hover i {
  margin-right: 10px;
}
@media screen and (max-width: 800px) {
  .follow {
    margin: 400px auto 0;
  }
}

</style>

  <ul class="cd-accordss-menu set-animated">
    <li class="has-children">

      <input type="checkbox" name="group-4" class="accord-input" id="group-4">
      <label class="accord-label" for="group-4"><i class="fa fa-cog iconz iconz"></i>Settings<i class="fa fa-chevron-right iconz-down"></i></label>

          <ul class="first-list">
            <li class="has-children">
              <div id="sett-test">

              </div>
            </li>      
          </ul>
    </li>
  </ul>

    

<?php
$settingsUrl = 'index.php?r=settings%2Fdefault';

$accordss = <<<JS
$(document).ready(function(){
  $.ajax({
    url: '$settingsUrl',
    success: function(data) {
        $('.sett-content').html(data);
     }
    });
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

  $('.set-animated').click(function(){
     $('.settings-container').css({
       'visibility':'visible',
       '-webkit-transition':'width 2s',
       'transition':'width 2s, height 2s',
       'width':'600px',
       'min-height':'500px'
      });
      $('.sider').hide('slow');
      $('.settings-content').show('slow');
  })

  $('.close-arrow').click(function(){
     $('.settings-container').css({
       'width':'300px',
       'min-height':'1px',
       'visibility':'hidden'
      });
      $('.settings-content').hide();
      setTimeout(function() { 
        $('.sider').show('slow');
    }, 900);
      
      
  })

  var Tabs = {

  init: function() {
    this.bindUIfunctions();
    this.pageLoadCorrectTab();
  },

  bindUIfunctions: function() {

    // Delegation
    $(document)
      .on("click", ".transformer-tabs a[href^='#']:not('.active')", function(event) {
        Tabs.changeTab(this.hash);
        event.preventDefault();
      })
      .on("click", ".transformer-tabs a.active", function(event) {
        Tabs.toggleMobileMenu(event, this);
        event.preventDefault();
      });

  },

  changeTab: function(hash) {

    var anchor = $("[href=' + hash + ']");
    var div = $(hash);

    // activate correct anchor (visually)
    anchor.addClass("active").parent().siblings().find("a").removeClass("active");

    // activate correct div (visually)
    div.addClass("active").siblings().removeClass("active");

    // update URL, no history addition
    // You'd have this active in a real situation, but it causes issues in an <iframe> (like here on CodePen) in Firefox. So commenting out.
    // window.history.replaceState("", "", hash);

    // Close menu, in case mobile
    anchor.closest("ul").removeClass("open");

  },

  // If the page has a hash on load, go to that tab
  pageLoadCorrectTab: function() {
    this.changeTab(document.location.hash);
  },

  toggleMobileMenu: function(event, el) {
    $(el).closest("ul").toggleClass("open");
  }

}

Tabs.init();

});

JS;
$this->registerJs($accordss);
?>