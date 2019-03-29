function closeMenu(data){
   // e.preventDefault(); 
	$('.list_load, .list_item').stop();
	data.removeClass('closed').addClass('opened');
	$('.board-open').addClass('board-closed');
	$('.side_menu').css({ 'left':'0px' });
	$('.beacon-wrapper').hide();
	$(".ubuxalogo").show();
    $(".menu-plus").hide();
	var count = $('.list_item').length;
	$('.list_load').slideDown( (count*.6)*100 );
	$('.list_item').each(function(i){
		var thisLI = $(this);
		timeOut = 100*i;
		setTimeout(function(){
			thisLI.css({
				'opacity':'1',
				'margin-left':'0'
			});
		},100*i);
	});
}

function openMenu(data){
    $('.list_load, .list_item').stop();
	data.removeClass('opened').addClass('closed');
	$(".ubuxalogo").hide();
    $(".menu-plus").show();
	$('.side_menu').css({ 'left':'-300px' });

	var count = $('.list_item').length;
	$('.list_item').css({
		'opacity':'0',
		'margin-left':'-20px'
	});
	$('.list_load').slideUp(300);
	$('.beacon-wrapper').show();
}

$(document).on('click','.js-menu_toggle.closed',function(e){
    var thisClass = $('.js-menu_toggle.closed');
	closeMenu(thisClass);
});



$(document).on('click','.js-menu_toggle.opened',function(){
	var thisClass = $('.js-menu_toggle.opened');
    openMenu(thisClass);
	
});

$(document).ready(function () {
	$('#content > div').hide();
	$('#content > div:first-of-type').show();
	var tabs =  $(".tabs li a");
  
	tabs.click(function() {
		var content = this.hash.replace('/','');
		tabs.removeClass("active");
		$(this).addClass("active");
    $("#content > div").hide();
    $(content).fadeIn(200);
	});



});

$(document).on('click',function (e) {
  side_menu = $('.side_menu');
  /* var id = (document).find('#kanban-refresh');
  if(e.target.id == "kanban-refresh"){
          e.stopPropagation();
  } */
  if (!side_menu.is(e.target) 
      && side_menu.has(e.target).length === 0){
    if($('.js-menu_toggle.opened')[0] && $('.board-open').hasClass('board-closed') && !$('.file-zoom-dialog').hasClass('in') && !$('.edocument-container').hasClass('opened')){
        $('.js-menu_toggle.opened').trigger('click');
        $('.edocument-container').css({'width': '300px', 'visibility': 'hidden', 'min-height':'1px'});
        $('.sider').show();
        $('.edocument-content').hide();
    } else {
    	
    }
	
  }
});


//var isiPod = /ipod/i.test(navigator.userAgent.toLowerCase());
var isiPod = /ipod/i.test(navigator.userAgent.toLowerCase());
var isiDevice = /ipad|iphone|ipod/i.test(navigator.userAgent.toLowerCase());
var isAndroid = /android/i.test(navigator.userAgent.toLowerCase());
var isWindowsPhone = /windows phone/i.test(navigator.userAgent.toLowerCase());
var isBlackBerry = /blackberry/i.test(navigator.userAgent.toLowerCase());

if (isiPod || isiDevice || isAndroid || isWindowsPhone || isBlackBerry)
{
//console.log('mobile');
}

