function closeMenu(data){
   // e.preventDefault(); 
	$('.list_load, .list_item').stop();
	data.removeClass('closed').addClass('opened');

	$('.side_menu').css({ 'left':'0px' });

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

	$('.side_menu').css({ 'left':'-300px' });

	var count = $('.list_item').length;
	$('.list_item').css({
		'opacity':'0',
		'margin-left':'-20px'
	});
	$('.list_load').slideUp(300);
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
  if (!side_menu.is(e.target) 
      && side_menu.has(e.target).length === 0){
    if($('.js-menu_toggle.opened')[0]){
        $('.js-menu_toggle.opened').trigger('click');
    } else {
        //do nothing
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

