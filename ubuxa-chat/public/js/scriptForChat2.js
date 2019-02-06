$ (function(){
  var socket = io('/chat');

  var username = $('body').data('username');
  var noChat = 0; //setting 0 if all chats histroy is not loaded. 1 if all chats loaded.
  var msgCount = 0; //counting total number of messages displayed.
  var oldInitDone = 0; //it is 0 when old-chats-init is not executed and 1 if executed.
  var roomId;//variable for setting room.
  var toUser; //variable for setting toUser.

  //passing data on connection.
  socket.on('connect',function(){
    socket.emit('set-user-data',username);
    // setTimeout(function() { alert(username+" logged In"); }, 500);

    socket.on('broadcast',function(data){
    document.getElementById("hell0").innerHTML += '<li>'+ data.description +'</li>';
    // $('#hell0').append($('<li>').append($(data.description).append($('<li>');
    $('#hell0').scrollTop($('#hell0')[0].scrollHeight);

});

  });//end of connect event.



  //receiving onlineStack.
  socket.on('onlineStack',function(stack){
    
	  var totalOnline = 0; // count for total online users
	var numberClass = 100;// for class name strating at 100
    $('#chat-sidebar').empty();// empty out the side bar
    $('#list').append($('<li>').append($('<button id="ubtn" class="btn btn-danger btn-block btn-lg"></button>').text("Group").css({"font-size":"18px"})));

    for (var user in stack){
      //setting txt1. shows users button.
	 // append all online users
		var contentDiv = $('<div id="sidebar-user-box" class = "'+numberClass+'" ></div>');//display each user section inside of a seperate div

		var nameSpan = $('<span id="slider-username"> </span>').text(user); // username which should be displayed on a span for every user

      if(user == username){
        var txt1 = $('<button class="boxF disabled"> </button>').text(user).css({"font-size":"18px"});
      }
      else{
        var txt1 = $('<button id="ubtn" class="btn btn-success  btn-md">').text(user).css({"font-size":"18px"});
      }
      //setting image tag and show if user is online or not  shows online status.
      if(stack[user] == "Online"){
		  var imageTag = $('<img src="user.png" style="border:solid green 1px; border-radious:50%;" />');
        var txt2 = $('<span class="badge"></span>').text("*"+stack[user]).css({"float":"right","color":"#009933","font-size":"18px"});
        totalOnline++;

      }
      else{
		  var imageTag = $('<img src="user.png" style="border:solid red 1px; border-radious:50%;" />');
        var txt2 = $('<span class="badge"></span>').text(stack[user]).css({"float":"right","color":"#a6a6a6","font-size":"18px"});
      }


		numberClass++ // used to change the class name from 100 t0 101 etc
      //listing all users.
      $('#list').append($('<li>').append(txt1,txt2));// this is an old implimentation should be cleaned out
      $('#chat-sidebar').append(contentDiv.append(imageTag,nameSpan));
      $('#totalOnline').text(totalOnline);
    }//end of for.
    $('#chat-sidebar').scrollTop($('#chat-sidebar').prop("scrollHeight"));
  }); //end of receiving onlineStack event.


  //on button click function.
  $(document).on("click","#sidebar-user-box",function(){

    //empty messages.
    $('#messages').empty();
    $('#typing').text("");
    msgCount = 0;
    noChat = 0;
    oldInitDone = 0;

    //assigning friends name to whom messages will send,(in case of group its value is Group).
    toUser = $(this).children().text();

    //showing and hiding relevant information.
    $('#frndName').text(toUser);
    $('#initMsg').hide();
    $('#chatForm').show(); //showing chat form.
    $('#sendBtn').hide(); //hiding send button to prevent sending of empty messages.
    //assigning two names for room. which helps in one-to-one and also group chat.
    if(toUser == "Group"){
      var currentRoom = "Group-Group";
      var reverseRoom = "Group-Group";
    }
    else{
      var currentRoom = username+"-"+toUser;
      var reverseRoom = toUser+"-"+username;
    }

    //event to set room and join.
    socket.emit('set-room',{name1:currentRoom,name2:reverseRoom});

  }); //end of on button click event.

  //event for setting roomId.
  socket.on('set-room',function(room){
    //empty messages.
    $('#messages').empty();
    $('#typing').text("");
    msgCount = 0;
    noChat = 0;
    oldInitDone = 0;
    //assigning room id to roomId variable. which helps in one-to-one and group chat.
    roomId = room;
    console.log("roomId : "+roomId);
    //event to get chat history on button click or as room is set.
    socket.emit('old-chats-init',{room:roomId,username:username,msgCount:msgCount});

  }); //end of set-room event.

  //on scroll load more old-chats.
  $('#scrl2').scroll(function(){

    if($('#scrl2').scrollTop() == 0 && noChat == 0 && oldInitDone == 1){
      $('#loading').show();
      socket.emit('old-chats',{room:roomId,username:username,msgCount:msgCount});
    }

  }); // end of scroll event.

  //listening old-chats event.
  socket.on('old-chats',function(data){

    if(data.room == roomId){
      oldInitDone = 1; //setting value to implies that old-chats first event is done.
      if(data.result.length != 0){
        $('#noChat').hide(); //hiding no more chats message.
        for (var i = 0;i < data.result.length;i++) {
          //styling of chat message.
          var chatDate = moment(data.result[i].createdOn).format("MMMM Do YYYY, hh:mm:ss a");
          var txt1 = $('<span></span>').text(data.result[i].msgFrom+" : ").css({"color":"#006080"});
          var txt2 = $('<span></span>').text(chatDate).css({"float":"right","color":"#a6a6a6","font-size":"16px"});
          var txt3 = $('<p></p>').append(txt1,txt2);
          var txt4 = $('<p></p>').text(data.result[i].msg).css({"color":"#000000"});
          //showing chat in chat box.
          $('#messages').prepend($('<li>').append(txt3,txt4));
          msgCount++;

        }//end of for.
        console.log(msgCount);
      }
      else {
        $('#noChat').show(); //displaying no more chats message.
        noChat = 1; //to prevent unnecessary scroll event.
      }
      //hiding loading bar.
      $('#loading').hide();

      //setting scrollbar position while first 5 chats loads.
      if(msgCount <= 5){
        $('#scrl2').scrollTop($('#scrl2').prop("scrollHeight"));
      }
    }//end of outer if.

  }); // end of listening old-chats event.

	socket.on('old-chats-for-invite',function(data){

    if(data.room == roomId){

      if(data.result.length != 0){
        $('#noChat').hide(); //hiding no more chats message.
        for (var i = 0;i < data.result.length;i++) {
//          //styling of chat message.
//          var chatDate = moment(data.result[i].createdOn).format("MMMM Do YYYY, hh:mm:ss a");
//          var txt1 = $('<span></span>').text(data.result[i].msgFrom+" : ").css({"color":"#006080"});
//          var txt2 = $('<span></span>').text(chatDate).css({"float":"right","color":"#a6a6a6","font-size":"16px"});
//          var txt3 = $('<p></p>').append(txt1,txt2);
//          var txt4 = $('<p></p>').text(data.result[i].msg).css({"color":"#000000"});
//          //showing chat in chat box.
//          $('#messages').prepend($('<li>').append(txt3,txt4));


			if(data.result[i].msgFrom == username){
				// find the to tab and display it

				var chatbox = $('.'+data.result[i].msgTo).attr("rel") ;

			$('<div class="msg-right">'+data.result[i].msg+' </div>').insertBefore('[rel="'+chatbox+'"] .msg_push');
			$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
			}else{
				//else find the from tabe and onto it
				var chatbox = $('.'+data.result[i].msgFrom).attr("rel") ;

			$('<div class="msg-left">'+data.result[i].msg+' </div>').insertAfter('[rel="'+chatbox+'"] .msg_push');
			$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
			}

			msgCount++;

        }//end of for.
		 oldInitDone = 1; //setting value to implies that old-chats first event is done.
        console.log(msgCount);
      }
      else {
        $('#noChat').show(); //displaying no more chats message.
        noChat = 1; //to prevent unnecessary scroll event.
      }
      //hiding loading bar.
      $('#loading').hide();

      //setting scrollbar position while first 5 chats loads.
      if(msgCount <= 5){
        $('#scrl2').scrollTop($('#scrl2').prop("scrollHeight"));
      }


    }//end of outer if.

  }); // end of listening old-chats event.

  // keyup handler.
  $('#myMsg').keyup(function(){
    if($('#myMsg').val()){
      $('#sendBtn').show(); //showing send button.
      socket.emit('typing');
    }
    else{
      $('#sendBtn').hide(); //hiding send button to prevent sending empty messages.
    }
  }); //end of keyup handler.

  //receiving typing message.
  socket.on('typing',function(msg){
    var setTime;
    //clearing previous setTimeout function.
    clearTimeout(setTime);
    //showing typing message.
    $('#typing').text(msg);
    //showing typing message only for few seconds.
    setTime = setTimeout(function(){
      $('#typing').text("");
    },3500);
  }); //end of typing event.

	//sending message (this could end up never to be used so remember to remove it when your sure) .
	$('form').submit(function(){
    socket.emit('chat-msg',{msg:$('#myMsg').val(),msgTo:toUser,date:Date.now()});
    $('#myMsg').val("");
    $('#sendBtn').hide();
    return false;
  }); //end of sending message.

	$(document).on('keypress', 'textarea' , function(e) {
        if (e.keyCode == 13 ) {
            var msg = $(this).val();
            toUser = $(this).parent().parent().parent().find('.msg_head span').text();
			var currentRoom = username+"-"+toUser;
			if(msg.trim().length != 0){

//			var chatbox = $(this).parents().parents().parents().attr("rel") ;
//			$('<div class="msg-right">'+msg+'</div>').insertBefore('[rel="'+chatbox+'"] .msg_push');
//			$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
			socket.emit('chat-msg',{msg:msg,msgTo:toUser,date:Date.now(),getRoom:currentRoom});
    		$(this).val('');

			return false;

			}
        }
    });



  //receiving messages.
  socket.on('chat-msg',function(data){
	  //msgFrom: socket.username,
        //msgTo: data.msgTo,

	 if($('.msg_box').hasClass(data.msgFrom) || data.msgFrom == username ){
		 console.log('doo nothing');
	 }else{
		 var senderUsername = data.msgFrom;
		var userID = senderUsername+'_id';
		createChateArea(senderUsername,userID);
	 }
	  alert(data.msgFrom)
			if(data.msgFrom == username){
				// find the to tab and display it

				var chatbox = $('.'+data.msgTo).attr("rel") ;

			$('<div class="msg-right">'+data.msg+' </div>').insertBefore('[rel="'+chatbox+'"] .msg_push');
			$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
			}else{
				alert(234567)
				//else find the from tabe and onto it
				var chatbox = $('.'+data.msgFrom).attr("rel") ;

			$('<div class="msg-right">'+data.msg+' </div>').insertBefore('[rel="'+chatbox+'"] .msg_push');
			$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
			}
    //styling of chat message.
    var chatDate = moment(data.date).format("MMMM Do YYYY, hh:mm:ss a");
    var txt1 = $('<span></span>').text(data.msgFrom+" : ").css({"color":"#006080"});
    var txt2 = $('<span></span>').text(chatDate).css({"float":"right","color":"#a6a6a6","font-size":"16px"});
    var txt3 = $('<p></p>').append(txt1,txt2);
    var txt4 = $('<p></p>').text(data.msg).css({"color":"#000000"});
    //showing chat in chat box.
    $('#messages').append($('<li>').append(txt3,txt4));
      msgCount++;
      console.log(msgCount);
      $('#typing').text("");
      $('#scrl2').scrollTop($('#scrl2').prop("scrollHeight"));

  }); //end of receiving messages.

  //on disconnect event.
  //passing data on connection.
  socket.on('disconnect',function(){


    //showing and hiding relevant information.
    $('#list').empty();
    $('#messages').empty();
    $('#typing').text("");
    $('#frndName').text("Disconnected..");
    $('#loading').hide();
    $('#noChat').hide();
    $('#initMsg').show().text("...Please, Refresh Your Page...");
    $('#chatForm').hide();
    msgCount = 0;
    noChat = 0;
  });//end of connect event.

//this area was added by kingsley of epsolun to manipulate the client side of things

	//this section would recive a request from the server which would pop up the chat area, clear it if any old message exist and send back a request back to the server to get old chat message.
	socket.on('set-join-room',function(room,senderUsername){
    	//empty messages.
    	$('#messages').empty();
    	$('#typing').text("");
    	msgCount = 0;
		noChat = 0;
		oldInitDone = 0;
		//assigning room id to roomId variable. which helps in one-to-one and group chat.
		roomId = room;
		console.log("roomId : "+roomId);
		var senderUsername = senderUsername;
		var userID = senderUsername+'_id';
		createChateArea(senderUsername,userID);

		//event to get chat history on button click or as room is set.
		socket.emit('old-chats-init-for-join-request',{room:roomId,username:username,msgCount:msgCount,sender:senderUsername});

  	});
	//end of set-join-room event.

	// this area would recive a request from another client to join a room, this would be done scilently  the client would get the message and request that the server adds a user to the room, after which old message should be pulled and rendered
	socket.on('join-room',function(room,from){

    	console.log("roomId : "+room);
		socket.emit('join-room',room,from);
	}); //end of set-room event.

});//end of function.


//function getMessages(){
//  $.get('http://localhost:3000/messages', (data) => {
//   data.forEach(addMessages);
//   })
// }
//
//function sendMessage(message){
//   $.post('http://localhost:3000/messages', message)
// }
