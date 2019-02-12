<?php
use yii\helpers\Url;
?>
<style>
 
/* -------------------------------- 
Main Components 
-------------------------------- */
.cd-edoc-accord-menu {
    width: 100%;
    max-width: 360px;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    margin-bottom: 0px;
    padding-left: 0px !important;
}
.cd-edoc-accord-menu .first-list {
  /* by defa.first-listt hide all sub menus */
  display: none;
}
.cd-edoc-accord-menu .second-list {
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.cd-edoc-accord-menu .accord-input {
  /* hide native checkbox */
  position: absolute;
  opacity: 0;
}
.has-edoc-children {
  list-style-type: none;
}
.second-list{
  border-bottom: 1px solid #6d6d6d;
}
.cd-edoc-accord-menu .accord-label, .cd-edoc-accord-menu a {
  display: block;
  padding: 18px 18px 18px 64px;
  color: #ffffff;
  font-size: 1.6rem;
}
.no-touch .cd-edoc-accord-menu .accord-label:hover, .no-touch .cd-edoc-accord-menu a:hover {
  background: #52565d;
}
.cd-edoc-accord-menu .accord-label::before, .cd-edoc-accord-menu .accord-label::after, .cd-edoc-accord-menu a::after {
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
.cd-edoc-accord-menu .accord-label {
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
.cd-edoc-accord-menu .accord-label::before, .cd-edoc-accord-menu .accord-label::after {
  background-image: url(../img/cd-icons.svg);
  background-repeat: no-repeat;
}
.cd-edoc-accord-menu .accord-label::before {
  /* arrow icon */
  left: 18px;
  background-position: 0 0;
  -webkit-transform: translateY(-50%) rotate(-90deg);
  -moz-transform: translateY(-50%) rotate(-90deg);
  -ms-transform: translateY(-50%) rotate(-90deg);
  -o-transform: translateY(-50%) rotate(-90deg);
  transform: translateY(-50%) rotate(-90deg);
}
.cd-edoc-accord-menu .accord-label::after {
  /* edoc icons */
  left: 41px;
  background-position: -16px 0;
}
.cd-edoc-accord-menu a::after {
  /* image icon */
  left: 36px;
  background: url(../img/cd-icons.svg) no-repeat -48px 0;
}
.cd-edoc-accord-menu .accord-input:checked + .accord-label::before {
  /* rotate arrow */
  -webkit-transform: translateY(-50%);
  -moz-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  -o-transform: translateY(-50%);
  transform: translateY(-50%);
}
.cd-edoc-accord-menu .accord-input:checked + .accord-label::after {
  /* show open edoc icon if item is checked */
  background-position: -32px 0;
}
.cd-edoc-accord-menu .accord-input:checked + .accord-label + .first-list,
.cd-edoc-accord-menu .accord-input:checked + .accord-label:nth-of-type(n) + .first-list {
  /* use label:nth-of-type(n) to fix a bug on safari (<= 8.0.8) with m.first-listtiple adjacent-sibling selectors*/
  /* show children when item is checked */
  display: block;
  padding-left: 0px !important;
}
.cd-edoc-accord-menu .first-list .accord-label,
.cd-edoc-accord-menu .first-list a {
  padding-left: 60px;
  background: #444359;
  font-size: 14px;
  color: #d9d9d9;
  border-radius: unset;
}
.no-touch .cd-edoc-accord-menu .first-list .accord-label:hover, .no-touch
.cd-edoc-accord-menu .first-list a:hover {
  background: #3c3f45;
}
.cd-edoc-accord-menu > li:last-of-type > .accord-label,
.cd-edoc-accord-menu > li:last-of-type > a,
.cd-edoc-accord-menu > li > .first-list > li:last-of-type .accord-label,
.cd-edoc-accord-menu > li > .first-list > li:last-of-type a {
  box-shadow: none;
}
.cd-edoc-accord-menu .first-list .accord-label::before {
  left: 36px;
}
.cd-edoc-accord-menu .first-list .accord-label::after,
.cd-edoc-accord-menu .first-list a::after {
  left: 59px;
}
.cd-edoc-accord-menu .first-list .first-list .accord-label,
.cd-edoc-accord-menu .first-list .first-list a {
  padding-left: 100px;
}
.cd-edoc-accord-menu .first-list .first-list .accord-label::before {
  left: 54px;
}
.cd-edoc-accord-menu .first-list .first-list .accord-label::after,
.cd-edoc-accord-menu .first-list .first-list a::after {
  left: 77px;
}
.cd-edoc-accord-menu .first-list .first-list .first-list .accord-label,
.cd-edoc-accord-menu .first-list .first-list .first-list a {
  padding-left: 118px;
}
.cd-edoc-accord-menu .first-list .first-list .first-list .accord-label::before {
  left: 72px;
}
.cd-edoc-accord-menu .first-list .first-list .first-list .accord-label::after,
.cd-edoc-accord-menu .first-list .first-list .first-list a::after {
  left: 95px;
}

.cd-edoc-accord-menu.animated .accord-label::before {
  /* this class is used if you're using jquery to animate the edoc-accord */
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
  color: #595959 !important;
  -webkit-transition: all 0.4s ease;
  -o-transition: all 0.4s ease;
  transition: all 0.4s ease;
}
.edoc-content{
    margin-right: 15px;
    margin-left: 35px;
}
.edocument-text{
  font-size: 25px;
}
</style>

  <ul class="cd-edoc-accord-menu folder-animated">
    <li class="has-edoc-children">

      <input type="checkbox" name="edoc-100" class="accord-input" id="edoc-100">
      <label class="accord-label edoc-label" for="edoc-100"><i class="fa fa-file-text-o iconz" aria-hidden="true"></i>Documents</label>
        <ul class="first-list">
            <li class="has-children">
              <div id="edoc-test">
               
              </div>
            </li>      
          </ul>
    </li>
  </ul>

<?php
$edocument = Url::to(['edocument/index']);
$edocaccord = <<<JS
/* $('.edoc-label').on('click',function(e){
  $.ajax({
    url: '$edocument',
    success: function(data) {
        $('.edoc-content').html(data);
     }
})*/

function expand() {
  $(".search-document").toggleClass("close");
  $(".input-search").toggleClass("square");
  if ($('.search-document').hasClass('close')) {
    $('.input-search').focus();
  } else {
    $('.input-search').blur();
  }
}
$('.search-document').on('click', expand);



$(document).ready(function(){
  var edocaccordsMenu = $('.cd-edoc-accord-menu');

  if( edocaccordsMenu.length > 0 ) {
    
    edocaccordsMenu.each(function(){
      var edocaccord = $(this);
      //detect change in the input[type="checkbox"] value
      edocaccord.on('change', 'input[type="checkbox"]', function(){
        var checkbox = $(this);
        console.log(checkbox.prop('checked'));
        ( checkbox.prop('checked') ) ? checkbox.siblings('ul').attr('style', 'display:none;').slideDown(300) : checkbox.siblings('ul').attr('style', 'display:block;').slideUp(300);
      });
    });
  }

    $('.folder-animated').click(function(){
     $('.edocument-container').css({
       'visibility':'visible',
       '-webkit-transition':'width 1s',
       'transition':'width 1s, height 1s',
       'width':'600px',
       'min-height':'100%',
       'background-color': 'rgba(253, 253, 253, 0.9)',
       'overflow': 'scroll',
      });
      $('.sider').hide('slow');
      
      $('.edocument-content').show('slow');
  })

  $('.close-arrow').click(function(){
     $('.edocument-container').css({
       'width':'300px',
       'min-height':'1px',
       'visibility':'hidden'
      });
      $('.edocument-content').hide();
      setTimeout(function() { 
        $('.sider').show('slow');
    }, 900);
  })
  })
JS;
$this->registerJs($edocaccord);
?>