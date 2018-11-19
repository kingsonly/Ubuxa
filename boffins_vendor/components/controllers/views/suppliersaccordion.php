<?php
use yii\helpers\Url;
?>
<style>
 
/* -------------------------------- 
Main Components 
-------------------------------- */
.cd-supps-accord-menu {
    width: 100%;
    max-width: 360px;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    margin-bottom: 0px;
}
.cd-supps-accord-menu .first-list {
  /* by defa.first-listt hide all sub menus */
  display: none;
}
.cd-supps-accord-menu .second-list {
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.cd-supps-accord-menu .accord-input {
  /* hide native checkbox */
  position: absolute;
  opacity: 0;
}
.has-supps-children {
  list-style-type: none;
}
.second-list{
  border-bottom: 1px solid #6d6d6d;
}
.cd-supps-accord-menu .accord-label, .cd-supps-accord-menu a {
  display: block;
  padding: 18px 18px 18px 64px;
  color: #ffffff;
  font-size: 1.6rem;
}
.no-touch .cd-supps-accord-menu .accord-label:hover, .no-touch .cd-supps-accord-menu a:hover {
  background: #52565d;
}
.cd-supps-accord-menu .accord-label::before, .cd-supps-accord-menu .accord-label::after, .cd-supps-accord-menu a::after {
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
.cd-supps-accord-menu .accord-label {
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
.cd-supps-accord-menu .accord-label::before, .cd-supps-accord-menu .accord-label::after {
  background-image: url(../img/cd-icons.svg);
  background-repeat: no-repeat;
}
.cd-supps-accord-menu .accord-label::before {
  /* arrow icon */
  left: 18px;
  background-position: 0 0;
  -webkit-transform: translateY(-50%) rotate(-90deg);
  -moz-transform: translateY(-50%) rotate(-90deg);
  -ms-transform: translateY(-50%) rotate(-90deg);
  -o-transform: translateY(-50%) rotate(-90deg);
  transform: translateY(-50%) rotate(-90deg);
}
.cd-supps-accord-menu .accord-label::after {
  /* folder icons */
  left: 41px;
  background-position: -16px 0;
}
.cd-supps-accord-menu a::after {
  /* image icon */
  left: 36px;
  background: url(../img/cd-icons.svg) no-repeat -48px 0;
}
.cd-supps-accord-menu .accord-input:checked + .accord-label::before {
  /* rotate arrow */
  -webkit-transform: translateY(-50%);
  -moz-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  -o-transform: translateY(-50%);
  transform: translateY(-50%);
}
.cd-supps-accord-menu .accord-input:checked + .accord-label::after {
  /* show open folder icon if item is checked */
  background-position: -32px 0;
}
.cd-supps-accord-menu .accord-input:checked + .accord-label + .first-list,
.cd-supps-accord-menu .accord-input:checked + .accord-label:nth-of-type(n) + .first-list {
  /* use label:nth-of-type(n) to fix a bug on safari (<= 8.0.8) with m.first-listtiple adjacent-sibling selectors*/
  /* show children when item is checked */
  display: block;
}
.cd-supps-accord-menu .first-list .accord-label,
.cd-supps-accord-menu .first-list a {
  padding-left: 60px;
  background: #444359;
  font-size: 14px;
  color: #d9d9d9;
  border-radius: unset;
}
.no-touch .cd-supps-accord-menu .first-list .accord-label:hover, .no-touch
.cd-supps-accord-menu .first-list a:hover {
  background: #3c3f45;
}
.cd-supps-accord-menu > li:last-of-type > .accord-label,
.cd-supps-accord-menu > li:last-of-type > a,
.cd-supps-accord-menu > li > .first-list > li:last-of-type .accord-label,
.cd-supps-accord-menu > li > .first-list > li:last-of-type a {
  box-shadow: none;
}
.cd-supps-accord-menu .first-list .accord-label::before {
  left: 36px;
}
.cd-supps-accord-menu .first-list .accord-label::after,
.cd-supps-accord-menu .first-list a::after {
  left: 59px;
}
.cd-supps-accord-menu .first-list .first-list .accord-label,
.cd-supps-accord-menu .first-list .first-list a {
  padding-left: 100px;
}
.cd-supps-accord-menu .first-list .first-list .accord-label::before {
  left: 54px;
}
.cd-supps-accord-menu .first-list .first-list .accord-label::after,
.cd-supps-accord-menu .first-list .first-list a::after {
  left: 77px;
}
.cd-supps-accord-menu .first-list .first-list .first-list .accord-label,
.cd-supps-accord-menu .first-list .first-list .first-list a {
  padding-left: 118px;
}
.cd-supps-accord-menu .first-list .first-list .first-list .accord-label::before {
  left: 72px;
}
.cd-supps-accord-menu .first-list .first-list .first-list .accord-label::after,
.cd-supps-accord-menu .first-list .first-list .first-list a::after {
  left: 95px;
}

.cd-supps-accord-menu.animated .accord-label::before {
  /* this class is used if you're using jquery to animate the supps-accord */
  -webkit-transition: -webkit-transform 0.3s;
  -moz-transition: -moz-transform 0.3s;
  transition: transform 0.3s;
}
.iconz {
    position: absolute;
    top: 16px;
    left: 12px;
    font-size: 18px;
    color: #595959 !important;
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
    color: #595959 !important;
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
</style>

  <ul class="cd-supps-accord-menu animated">
    <li class="has-supps-children">

      <input type="checkbox" name="supps-100" class="accord-input" id="supps-100">
      <label class="accord-label" for="supps-100"><i class="fa fa-building iconz"></i>Suppliers<i class="fa fa-chevron-down iconz-down"></i></label>

          <ul class="first-list">
            <li class="has-clients-children client-child supplier-first-child">
              <i class="fa fa-eye" style="color:#fff"> </i><span class="child-name">View Suppliers</span>      
            </li>
            <li class="has-clients-children client-child supplier-last-child">
              <i class="fa fa-plus" style="color:#fff"></i><span class="child-name">Create Suppliers</span>   
            </li>    
          </ul>
    </li>
  </ul>

<?php
$supplierUrlExisting = Url::to(['supplier/create']);
$supplierUrlView = Url::to(['supplier/index']);
$suppsaccord = <<<JS
$(document).ready(function(){
  var suppsaccordsMenu = $('.cd-supps-accord-menu');

  if( suppsaccordsMenu.length > 0 ) {
    
    suppsaccordsMenu.each(function(){
      var suppsaccord = $(this);
      //detect change in the input[type="checkbox"] value
      suppsaccord.on('change', 'input[type="checkbox"]', function(){
        var checkbox = $(this);
        console.log(checkbox.prop('checked'));
        ( checkbox.prop('checked') ) ? checkbox.siblings('ul').attr('style', 'display:none;').slideDown(300) : checkbox.siblings('ul').attr('style', 'display:block;').slideUp(300);
      });
    });
  }

  $(document).on('click','.supplier-last-child', function(){

      $('.client-containers').css({
           'visibility':'visible',
           '-webkit-transition':'width 2s',
           'transition':'width 2s, height 2s',
           'width':'600px',
           'min-height':'500px'
      });
    
      $('.sider').hide('slow');
      $('.client-content').show('slow');
    
      $('.close-arrow').click(function(){
          $('.client-containers').css({
           'width':'300px',
           'min-height':'1px',
           'visibility':'hidden'
          });
          $('.client-content').hide();
          setTimeout(function() { 
            $('.sider').show('slow');
          }, 900);
      })
      $('.supplierLoader').show();

      $.ajax({
            url: '$supplierUrlExisting',
            type: 'POST',
            data: {
                existingId:1
              },
            success: function(response) {
            $('.supplierLoader').hide();
            $('.client_template').html(response);
            },
            error: function(res, sec){
              $('.supplierLoader').show();
            }
      }); 

            
  })

$(document).on('click','.supplier-first-child', function(){
      $('.client-containers').css({
        'visibility':'visible',
        '-webkit-transition':'width 2s',
        'transition':'width 2s, height 2s',
        'width':'600px',
        'min-height':'500px'
      });
      $('.sider').hide('slow');
      $('.client-content').show('slow');
      $(document).find('.th-table').show('slow');

      $('.close-arrow').click(function(){
          $('.client-containers').css({
              'width':'300px',
              'min-height':'1px',
              'visibility':'hidden'
          });

          $(document).find('.th-table').hide();
          $('.client-content').hide();
          setTimeout(function() { 
            $('.sider').show('slow');
          }, 900);
      })
    
    
      $('.supplierLoader').show();

      $.ajax({
            url: '$supplierUrlView',
            type: 'POST',
            data: {
                existingId:1
              },
            success: function(response) {
            $('.supplierLoader').hide();
            $('.client_template').html(response);
            },
            error: function(res, sec){
              $('.supplierLoader').show();
          }
       }); 
});
});
JS;
$this->registerJs($suppsaccord);
?>
