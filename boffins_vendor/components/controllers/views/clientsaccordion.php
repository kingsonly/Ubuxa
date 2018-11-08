<style>
 
/* -------------------------------- 
Main Components 
-------------------------------- */
.cd-clients-accord-menu {
    width: 100%;
    max-width: 360px;
    background: #3F51B5;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    margin-bottom: 0px;
}
.cd-clients-accord-menu .first-list {
  /* by defa.first-listt hide all sub menus */
  display: none;
}
.cd-clients-accord-menu .second-list {
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.cd-clients-accord-menu .accord-input {
  /* hide native checkbox */
  position: absolute;
  opacity: 0;
}
.has-clients-children {
  list-style-type: none;
}
.second-list{
  border-bottom: 1px solid #6d6d6d;
}
.cd-clients-accord-menu .accord-label, .cd-clients-accord-menu a {
  display: block;
  padding: 18px 18px 18px 64px;
  background: #3F51B5;
  color: #ffffff;
  font-size: 1.6rem;
}
.no-touch .cd-clients-accord-menu .accord-label:hover, .no-touch .cd-clients-accord-menu a:hover {
  background: #52565d;
}
.cd-clients-accord-menu .accord-label::before, .cd-clients-accord-menu .accord-label::after, .cd-clients-accord-menu a::after {
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
.cd-clients-accord-menu .accord-label {
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
.cd-clients-accord-menu .accord-label::before, .cd-clients-accord-menu .accord-label::after {
  background-image: url(../img/cd-icons.svg);
  background-repeat: no-repeat;
}
.cd-clients-accord-menu .accord-label::before {
  /* arrow icon */
  left: 18px;
  background-position: 0 0;
  -webkit-transform: translateY(-50%) rotate(-90deg);
  -moz-transform: translateY(-50%) rotate(-90deg);
  -ms-transform: translateY(-50%) rotate(-90deg);
  -o-transform: translateY(-50%) rotate(-90deg);
  transform: translateY(-50%) rotate(-90deg);
}
.cd-clients-accord-menu .accord-label::after {
  /* folder icons */
  left: 41px;
  background-position: -16px 0;
}
.cd-clients-accord-menu a::after {
  /* image icon */
  left: 36px;
  background: url(../img/cd-icons.svg) no-repeat -48px 0;
}
.cd-clients-accord-menu .accord-input:checked + .accord-label::before {
  /* rotate arrow */
  -webkit-transform: translateY(-50%);
  -moz-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  -o-transform: translateY(-50%);
  transform: translateY(-50%);
}
.cd-clients-accord-menu .accord-input:checked + .accord-label::after {
  /* show open folder icon if item is checked */
  background-position: -32px 0;
}
.cd-clients-accord-menu .accord-input:checked + .accord-label + .first-list,
.cd-clients-accord-menu .accord-input:checked + .accord-label:nth-of-type(n) + .first-list {
  /* use label:nth-of-type(n) to fix a bug on safari (<= 8.0.8) with m.first-listtiple adjacent-sibling selectors*/
  /* show children when item is checked */
  display: block;
}
.cd-clients-accord-menu .first-list .accord-label,
.cd-clients-accord-menu .first-list a {
  padding-left: 60px;
  background: #444359;
  font-size: 14px;
  color: #d9d9d9;
  border-radius: unset;
}
.no-touch .cd-clients-accord-menu .first-list .accord-label:hover, .no-touch
.cd-clients-accord-menu .first-list a:hover {
  background: #3c3f45;
}
.cd-clients-accord-menu > li:last-of-type > .accord-label,
.cd-clients-accord-menu > li:last-of-type > a,
.cd-clients-accord-menu > li > .first-list > li:last-of-type .accord-label,
.cd-clients-accord-menu > li > .first-list > li:last-of-type a {
  box-shadow: none;
}
.cd-clients-accord-menu .first-list .accord-label::before {
  left: 36px;
}
.cd-clients-accord-menu .first-list .accord-label::after,
.cd-clients-accord-menu .first-list a::after {
  left: 59px;
}
.cd-clients-accord-menu .first-list .first-list .accord-label,
.cd-clients-accord-menu .first-list .first-list a {
  padding-left: 100px;
}
.cd-clients-accord-menu .first-list .first-list .accord-label::before {
  left: 54px;
}
.cd-clients-accord-menu .first-list .first-list .accord-label::after,
.cd-clients-accord-menu .first-list .first-list a::after {
  left: 77px;
}
.cd-clients-accord-menu .first-list .first-list .first-list .accord-label,
.cd-clients-accord-menu .first-list .first-list .first-list a {
  padding-left: 118px;
}
.cd-clients-accord-menu .first-list .first-list .first-list .accord-label::before {
  left: 72px;
}
.cd-clients-accord-menu .first-list .first-list .first-list .accord-label::after,
.cd-clients-accord-menu .first-list .first-list .first-list a::after {
  left: 95px;
}

.cd-clients-accord-menu.animated .accord-label::before {
  /* this class is used if you're using jquery to animate the clients-accord */
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

  <ul class="cd-clients-accord-menu animated">
    <li class="has-clients-children">

      <input type="checkbox" name="clients-100" class="accord-input" id="clients-100">
      <label class="accord-label" for="clients-100"><i class="fa fa-building-o iconz"></i>Clients<i class="fa fa-chevron-down iconz-down"></i></label>

          <ul class="first-list">
            <li class="has-clients-children">
              Test test         
            </li>      
          </ul>
    </li>
  </ul>

<?php
$clientsaccord = <<<JS
$(document).ready(function(){
  var clientsaccordsMenu = $('.cd-clients-accord-menu');

  if( clientsaccordsMenu.length > 0 ) {
    
    clientsaccordsMenu.each(function(){
      var clientsaccord = $(this);
      //detect change in the input[type="checkbox"] value
      clientsaccord.on('change', 'input[type="checkbox"]', function(){
        var checkbox = $(this);
        console.log(checkbox.prop('checked'));
        ( checkbox.prop('checked') ) ? checkbox.siblings('ul').attr('style', 'display:none;').slideDown(300) : checkbox.siblings('ul').attr('style', 'display:block;').slideUp(300);
      });
    });
  } 

  $('.animated').click(function(){
     $('.client-container').css({
       'visibility':'visible',
       '-webkit-transition':'width 2s',
       'transition':'width 2s, height 2s',
       'width':'600px',
       'min-height':'500px'
      });
      $('.sider').hide('slow');
      $('.client-content').show('slow');
  })

  $('.close-arrow').click(function(){
     $('.client-container').css({
       'width':'300px',
       'min-height':'1px',
       'visibility':'hidden'
      });
      $('.client-content').hide();
      setTimeout(function() { 
        $('.sider').show('slow');
    }, 900);
      
      
  })
});

JS;
$this->registerJs($clientsaccord, $this::POS_READY);
?>