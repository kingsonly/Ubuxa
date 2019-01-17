$(document).ready(function(){
     
	
	 var arr = []; // List of users	
	
	$(document).on('click', '.msg_head', function() {	
		var chatbox = $(this).parents().attr("rel") ;
		$('[rel="'+chatbox+'"] .msg_wrap').slideToggle('slow');
		return false;
	});
	
	
	$(document).on('click', '.close', function() {	
		var chatbox = $(this).parents().parents().attr("rel") ;
		$('[rel="'+chatbox+'"]').hide();
		arr.splice($.inArray(chatbox, arr), 1);
		displayChatBox();
		return false;
	});
	
	$(document).on('click', '#sidebar-user-box', function() {
	
	 var userID = $(this).attr("class");
	 var username = $(this).children().text() ;
	 
	 if ($.inArray(userID, arr) != -1)
	 {
      arr.splice($.inArray(userID, arr), 1);
     }
	 
	 arr.unshift(userID);
	 chatPopup =  '<div class="msg_box" style="right:270px" rel="'+ userID+'">'+
					'<div class="msg_head">'+username +
					'<div class="close">x</div> </div>'+
					'<div class="msg_wrap"> <div class="msg_body">	<div class="msg_push"></div> </div>'+
					'<div class="msg_footer"><textarea class="msg_input" rows="4"></textarea></div> 	</div> 	</div>' ;					
				
     $("body").append(  chatPopup  );
	 displayChatBox();
		getMessages();
	});
	
	
	$(document).on('keypress', 'textarea' , function(e) {       
        if (e.keyCode == 13 ) { 
			var name =  $(this).parents().parents().parents().find().text();
            var msg = $(this).val();		
			
			if(msg.trim().length != 0){	
				
       sendMessage({
          name: 'kings',//$("#name").val(), //also for from who
          message:msg,//$("#message").val()
          to:name,//$("#to").val()
	   });
        
    }
			}
        }
    );
	
		
    
	function displayChatBox(){ 
	    i = 270 ; // start position
		j = 260;  //next position
		
		$.each( arr, function( index, value ) {  
		   if(index < 4){
	         $('[rel="'+value+'"]').css("right",i);
			 $('[rel="'+value+'"]').show();
		     i = i+j;			 
		   }
		   else{
			 $('[rel="'+value+'"]').hide();
		   }
        });		
	}
	
	
	
	$(() => {
    $("#send").click(()=>{
       sendMessage({
          name: $("#name").val(), 
          message:$("#message").val(),
          to:$("#to").val(),
	   });
		
        })
      getMessages()
    })

function addMessages2(message){
   $('#messages').append('<h4>'+ message.name +'</h4><p>'+  message.message +'</p>')
   }

function addMessages(message){
   var chatbox = $('.msg_box').parents().parents().parents().attr("rel") ;
			$('<div class="msg-right">'+message.name+' '+message.to+' '+message.message+' </div>').insertBefore('.msg_push');
			$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
   }

function getMessages(){
  $.get('http://localhost:3000/messages', (data) => {
   data.forEach(addMessages);
   })
 }

function sendMessage(message){
   $.post('http://localhost:3000/messages', message)
 }
	
	
});

