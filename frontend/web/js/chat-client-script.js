var arr = []; // List of users

$('<audio id="chatAudio" src="audio/notify.ogg" type="audio/ogg"></audio>').appendTo('body');// sound file used on chat


/**
 * @function createChateArea
 * this function sole responsibility is to create dynamic chat box which would show below the page
 *
 */
// this function is used to create a chat area
function createChateArea(username,userId,folderDetailsTitle,folderDetailsId,userImage){
	// if user id is not  =  -1 then user tab has already been created
	roomid = '';
	var popupClass = username+'-'+folderDetailsId;
	if ($.inArray(userId, arr) != -1){
		arr.splice($.inArray(popupClass, arr), 1);
	}

	arr.unshift(popupClass);
	chatPopup =  '<div class="msg_box ' +username+'-'+folderDetailsId+'"data-msgcount="0" data-oldinitdone="0" style="right:270px" rel="'+ popupClass+'" data-userimage="'+userImage+'">'+
	'<div class="msg_head"> <span>'+username +
	'</span><div class="close">x</div> </div>'+
	'<div class="msg_wrap"> <div id="scrl2" class="msg_body">	<div class="msg_push"> click to load</div> </div>'+
	'<div class="msg_footer"><textarea class="msg_input" rows="4" placeholder="Enter message"></textarea></div> 	</div> 	</div>' ;

	$("body").append(  chatPopup  ); // append html to body
	displayChatBox() // function is used to display the chat box that has just bn created
	addFolderDiv(popupClass,folderDetailsTitle,folderDetailsId) // used to add folder div which helps in setting the soccek room
}

/**
 *
 * @function  addFolderDiv 
 *  this function is added to the @function createChateArea to display the folder div on the chat box
 * as such making chatbox folder specific.
 */
function addFolderDiv(popupClass,folderDetailsTitle,folderDetailsId){
	$('<div class="msg_folder_head" data-chatfolderid="'+folderDetailsId+'" data-chatfoldertitle="'+folderDetailsTitle+'"> <div class="chat_folder_content"> <div class="chat_folder_img"></div> <div class="chat_folder_title">'+folderDetailsTitle +
	'</div></div> </div>').insertAfter('.'+popupClass +' .msg_head')
}

// display chat box and possition it right on the body of the page

/**
 *
 * @function  displayChatBox 
 *  this function is added to the @function createChateArea to position the  chatbox on directly below 
 *  the @body tag and to keep track of each chat box position, helping to prevent overlaying of chat
 *  box, of different user/ different folders
 */
function displayChatBox(){
	i = 270 ; // start position
	j = 290;  //next position

	$.each( arr, function( index, value ) {
		if(index < 3){
			$('[rel="'+value+'"]').css("right",i);
			$('[rel="'+value+'"]').show();
			i = i+j;
		}else{
			$('[rel="'+value+'"]').hide();
		}
	});
}

$(document).ready(function(){
	localStorage.removeItem('chatbox'); // clear chatbox key from local storage on document load
	// when clicked on text area if msg head has a chat blink remove the blinking class
	
	/**
	 *
	 * @event  click event on @cssclass msg_input 
	 *  the sole aim of this event is to stop the message head from blinking after a user clicks on or focus
	 *  on any chatbox textarea, indicating that the message have been seen and possibly read
	 */
	$(document).on('click focus','.msg_input',function(){
		// remove blink class when cliked on text area
		var findInputParentHead = $(this).parent().parent().parent();
		var msgHead = findInputParentHead.find('.msg_head')
		if(msgHead.hasClass('chatblink')){
			msgHead.removeClass('chatblink');
		}
	})

	// when clicked on msg head if msg head has a chat blink remove the blinking class
	/**
	 *
	 * @event  click focus event on @cssclass msg_box 
	 *  the sole aim of this event is to stop the message head from blinking after a user clicks on or 
	 * focus
	 *  on any chatbox textarea, indicating that the message have been seen and possibly read
	 */
	$(document).on('click focus','.msg_box',function(){
		// remove blink class when click on head
		var currentElement = $(this);
		if(currentElement.hasClass('chatblink')){
			currentElement.removeClass('chatblink');
		}
	})

	
	/**
	 *
	 * @event  click focus event on @cssclass msg_head 
	 *  on click on message head the chat box should toggle open or close as the case may be.
	 */
	
	$(document).on('click', '.msg_head', function() {
		var chatbox = $(this).parents().attr("rel") ;
		$('[rel="'+chatbox+'"] .msg_wrap').slideToggle('slow');
		return false;
	});

	$(document).on('click', '.close', function() {
		var chatbox = $(this).parents().parents().attr("rel") ;
		$('[rel="'+chatbox+'"]').remove();
		arr.splice($.inArray(chatbox, arr), 1);
		displayChatBox();
		return false;
	});

	$ (function(){
		var socket = io('//127.0.0.1:4000');

		var username = $('body').data('username');
		var noChat = 0; //setting 0 if all chats histroy is not loaded. 1 if all chats loaded.
		//var msgCount = 0; //counting total number of messages displayed.
		var oldInitDone = 0; //it is 0 when old-chats-init is not executed and 1 if executed.
		var roomId;//variable for setting room.
		var toUser; //variable for setting toUser.
		var mainUserImage = $('body').data('userimage');// holds value for users image which would be displayed beside each chat 

		//passing data on connection.
		socket.on('connect',function(){
			socket.emit('set-user-data',username);
			
			socket.on('broadcast',function(data){
				console.log('socket join')
			});

		});
		//end of connect event.


		//receiving onlineStack.
		socket.on('onlineStack',function(stack){
			var sessionUrl = $('body').data('sessionlink');
			console.log(stack);
			$.post(sessionUrl,{activitiesArray:stack},function(){
				if($(".folderusers").length > 0){

					$.pjax.reload({container:"#user_prefixuserjax",async: false});
				}
			})
		});
		
		socket.on('wrong',function(stack){
			console.log(stack);
		});
		//end of receiving onlineStack event.

		$(document).on('click', '.blue', function() {
			var toUsername = $(this).data('username') ;
			var userID = toUsername+'_id';
			var folderDetailsTitle = $(document).find('.folderdetls').data('foldertitle');
			var folderDetailsId = $(document).find('.folderdetls').data('folderid');
			var userImage = $(this).data('userimage');

			//empty messages.
			$('#messages').empty();
			$('#typing').text("");
			msgCount = 0;
			noChat = 0;
			oldInitDone = 0;

			//assigning friends name to whom messages will send,(in case of group its value is Group).
			toUser = toUsername;

			//showing and hiding relevant information.
			$('#frndName').text(toUser);
			$('#initMsg').hide();

			if(toUser == "Group"){
				var currentRoom = "Group-Group";
				var reverseRoom = "Group-Group";
			}else{
				var currentRoom = username+"-"+toUser+'-'+folderDetailsId;
				var reverseRoom = toUser+"-"+username+'-'+folderDetailsId;

			}

			//event to set room and join.
			socket.emit('set-room',{name1:currentRoom,name2:reverseRoom,toUser:toUser});

			createChateArea(toUsername,userID,folderDetailsTitle,folderDetailsId,userImage);

		});
		//event for setting roomId.
		socket.on('set-room',function(room,toUsername,folderId){
			// oldchatsnewjoin
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
			socket.emit('old-chats-init',{room:roomId,username:username,msgCount:msgCount,sender:toUsername,folderId:folderId});
			$('.'+toUsername).attr('data-roomid',roomId);// create a roomid attribute and pass room id to it, Note this room id would be used to load old msg on scrool to top


		}); //end of set-room event.

		//on scroll load more old-chats.
		$(document).on('click','.msg_push',function(){
			var getParent = $(this).parent().parent().parent(); // getting main chat containing div
			
			var getClassData = $(this).data('class'); // click button has a data-class attribute which hold exact message count object key

			oldInitDone = getParent.data('oldinitdone'); // old init done which is found on the head of the chat box
			msgCounts =  JSON.parse(localStorage.getItem('chatbox'));//getting message count from local storage
			
			roomId = getParent.data('roomid');// found at the head of chat box/ holds the room id, which would be used to fetch chat history
			senderUsername = getParent.attr('rel');// found at the head of chat box/ holds the room id, which would be used to fetch chat history
			folderId = senderUsername.split('-');
			userImage = getParent.data('userimage')
			alert(msgCounts[getClassData]);
			if($(this).scrollTop() == 0  && oldInitDone == 1){

				socket.emit('old-chats',{room:roomId,username:username,msgCount:msgCounts[getClassData],sender:senderUsername,folderId:folderId[1],userImage:userImage});
			}

		}); // end of scroll event.

		//listening old-chats event.
		socket.on('old-chats',function(data){
			$(".msg_push").show();
			var msgcount;
			var watermack = $('<div class="background"><p class="bg-text">Note that <br/>this chat is<br/> folder specific</p></div>');

			if(data.room == roomId){

				if(data.result.length != 0){
					$('#noChat').hide(); //hiding no more chats message.

					for (var i = 0;i < data.result.length;i++) {

					var chatDate = moment(data.result[i].createdOn).format("MMMM Do YYYY, hh:mm:ss a");

						if(data.result[i].msgFrom == username){
					// find the to tab and display it

							var chatbox = $('.'+data.sender).attr("rel") ;

							$('<div class="msg_chat_container msg-right"><div class="msg_chat_content"><div class="msg_chat_img_empty"></div><div class="msg_chat_text">'+data.result[i].msg+'</div></div><div class="msg_chat_date">'+chatDate+'</div></div>').insertAfter('[rel="'+chatbox+'"] .msg_push');
							
							$('.'+chatbox).data('userimage')

							var attr = 'chatbox';
							if(i == data.result.length-1){
								if (localStorage.getItem(attr) !== null) {
									var storedChatInitCounters =  JSON.parse(localStorage.getItem(attr));
									if(chatbox in storedChatInitCounters){
										storedChatInitCounters[chatbox] =  storedChatInitCounters[chatbox] + 5;
										console.log(storedChatInitCounters);
										//storedChatInitCounters.push(oldStoredChatInitCounters)
										newArray = storedChatInitCounters;
										console.log(newArray);
										localStorage.setItem('chatbox', JSON.stringify(newArray));
										//check if key exist 
										// if it does do an addition else create a new key by runing an array push and passing the value 1 to it
									}else{
										// add the new key
										storedChatInitCounters[chatbox] = 6;
										console.log(storedChatInitCounters);
										//storedChatInitCounters.push(oldStoredChatInitCounters)
										newArray = storedChatInitCounters;
										console.log(newArray);
										localStorage.setItem('chatbox', JSON.stringify(newArray));
										$('.'+chatbox).find('.msg_push').attr('data-class',chatbox);
										$('.'+chatbox).attr('data-oldinitdone',1);
										$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
									}
									
								}else{
									newArray = {};
									//newArray = {chatbox:1};
									newArray[chatbox] = 6;
									localStorage.setItem('chatbox', JSON.stringify(newArray));
									$('.'+chatbox).attr('data-oldinitdone',1);
									$('.'+chatbox).find('.msg_push').attr('data-class',chatbox);
									$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
								}
							}
						}else{
							//else find the from tabe and onto it
							var chatbox = $('.'+data.sender).attr("rel") ;
							imageurl = $('.'+chatbox).data('userimage');

							$('<div class="msg_chat_container msg-left"><div class="msg_chat_content"><div class="msg_chat_img">'+'<img src="'+imageurl+'"/></div><div class="msg_chat_text">'+data.result[i].msg+'</div></div><div class="msg_chat_date">'+chatDate+'</div></div>').insertAfter('[rel="'+chatbox+'"] .msg_push');
							


							var attr = 'chatbox';
							if(i == data.result.length-1){
								if (localStorage.getItem(attr) !== null) {
									var storedChatInitCounters =  JSON.parse(localStorage.getItem(attr));
									if(chatbox in storedChatInitCounters){
										storedChatInitCounters[chatbox] =  storedChatInitCounters[chatbox] + 5;
										console.log(storedChatInitCounters);
										//storedChatInitCounters.push(oldStoredChatInitCounters)
										newArray = storedChatInitCounters;
										console.log(newArray);
										localStorage.setItem('chatbox', JSON.stringify(newArray));
										//check if key exist 
										// if it does do an addition else create a new key by runing an array push and passing the value 1 to it
									}else{
										// add the new key
										storedChatInitCounters[chatbox] = 6;
										console.log(storedChatInitCounters);
										//storedChatInitCounters.push(oldStoredChatInitCounters)
										newArray = storedChatInitCounters;
										console.log(newArray);
										localStorage.setItem('chatbox', JSON.stringify(newArray));
										$('.'+chatbox).find('.msg_push').attr('data-class',chatbox);
										$('.'+chatbox).attr('data-oldinitdone',1);
										$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
									}
									
								}else{
									newArray = {};
									//newArray = {chatbox:1};
									newArray[chatbox] = 6;
									localStorage.setItem('chatbox', JSON.stringify(newArray));
									$('.'+chatbox).attr('data-oldinitdone',1);
									$('.'+chatbox).find('.msg_push').attr('data-class',chatbox);
									$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
								}
							}
						}




					}//end of for.

					oldInitDone = 1; //setting value to implies that old-chats first event is done.
					console.log(msgCount);
				}else {
					//var chatbox = $('.'+data.result[i].msgTo).attr("rel") ;

					watermack.insertBefore('.'+data.sender +' .msg_body')
					$('#noChat').show(); //displaying no more chats message.
					noChat = 1; //to prevent unnecessary scroll event.
				}

				//hiding loading bar.
				$('#loading').hide();

				//setting scrollbar position while first 5 chats loads.
				if($('.'+data.sender).attr('data-oldinitdone') == 0){
					
					$('#scrl2').scrollTop($('#scrl2').prop("scrollHeight"));
					$('.'+chatbox).attr('data-oldinitdone',1);
					console.log(data);
				}



			}//end of outer if.

		}); // end of listening old-chats event.

		socket.on('old-chats-for-invite',function(data){
			$(".msg_push").show();
			var watermack = $('<div class="background"><p class="bg-text">Note that <br/>this chat is<br/> folder specific</p></div>');
			imageurl = data.userImage;
			if(data.room == roomId){
				$('#chatAudio')[0].play();
				if(data.result.length != 0){
					$('#noChat').hide(); //hiding no more chats message.

					for (var i = 0;i < data.result.length;i++) {

					var chatDate = moment(data.result[i].createdOn).format("MMMM Do YYYY, hh:mm:ss a");

						if(data.result[i].msgFrom == username){
					// find the to tab and display it

							var chatbox = $('.'+data.result[i].msgTo+'-'+data.folderId).attr("rel") ;

							$('<div class="msg_chat_container msg-right"><div class="msg_chat_content"><div class="msg_chat_img_empty"></div><div class="msg_chat_text">'+data.result[i].msg+'</div></div><div class="msg_chat_date">'+chatDate+'</div></div>').insertAfter('[rel="'+chatbox+'"] .msg_push');
							

							if(i == data.result.length-1){

								msgcount = $('.'+chatbox).data('msgcount');
								changeMsgCount = parseInt(msgcount) + 1;

								$('.'+chatbox).attr('data-msgcount',msgcount);
								$('.'+chatbox).attr('data-oldinitdone',1);
								$('.'+chatbox).attr('data-userimage',imageurl);


							}
						}else{
							//else find the from tabe and onto it
							var chatbox = $('.'+data.result[i].msgFrom+'-'+data.folderId).attr("rel") ;
							$(document).find('.'+chatbox).data('userimage',imageurl);

							$('<div class="msg_chat_container msg-left"><div class="msg_chat_content"><div class="msg_chat_img">'+'<img src="'+data.userImage+'"/></div><div class="msg_chat_text">'+data.result[i].msg+'</div></div><div class="msg_chat_date">'+chatDate+'</div></div>').insertAfter('[rel="'+chatbox+'"] .msg_push');
							

							if(i == data.result.length-1){

								msgcount = $('.'+chatbox).data('msgcount');
								changeMsgCount = parseInt(msgcount) + 1;

								$('.'+chatbox).attr('data-msgcount',changeMsgCount);
								$('.'+chatbox).attr('data-oldinitdone',1);
								$('.'+chatbox).attr('data-userimage',imageurl);


							}
							}



					}//end of for.

					oldInitDone = 1; //setting value to implies that old-chats first event is done.
					console.log(msgCount);
				}else {
					//var chatbox = $('.'+data.result[i].msgTo).attr("rel") ;

					watermack.insertBefore('.'+data.sender +' .msg_body')
					$('#noChat').show(); //displaying no more chats message.
					noChat = 1; //to prevent unnecessary scroll event.
				}

				//hiding loading bar.
				$('#loading').hide();

				//setting scrollbar position while first 5 chats loads.
				


			}//end of outer if.

		}); // end of listening old-chats event.

		// keyup handler.
		$(document).on('keyup','.msg_input',function(){

			var msgValue = $(this).val(); // msg string
			var getToUserName = $(this).parent().parent().parent().attr('rel');
			var splitToUserName = getToUserName.split('-');
			socket.emit('typing',{userTo:getToUserName,userFrom:username,msg:msgValue});
		}); //end of keyup handler.

		//receiving typing message.
		socket.on('typing',function(data){
			var imageurl = '';
			var timeout;
			if($('.msg_box').hasClass(data.updateChatBox)){

				var chatbox = $('.'+data.updateChatBox).attr("rel") ;
				if($('[rel="'+chatbox+'"] .msg_body').find('.remove').length !== 0){
					// clear text and add a new text but remove old text first
					$('[rel="'+chatbox+'"] .msg_body .remove').find('.msg_chat_tex').empty(); // empty the content of the msg text

					$('[rel="'+chatbox+'"] .msg_body .remove').find('.msg_chat_tex').text(data.msg);// append new text to the chat remove div

					$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
					clearTimeout(timeout);
					timeout = setTimeout(function(){
						$('[rel="'+chatbox+'"] .msg_body .remove').remove();
					}, 8000);
				}else{
					// append a new remove area
					$('[rel="'+chatbox+'"] .msg_body').append('<div class="msg_chat_container remove msg-left"><div class="msg_chat_content"><div class="msg_chat_img">'+'<img style="display:none" src="'+imageurl+'"/></div><div class="msg_chat_text">'+data.msg+'</div></div></div>');
    				timeout = setTimeout(function(){
						$('[rel="'+chatbox+'"] .msg_body .remove').remove();
					}, 5000);
					$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
				}

			}





//			 setTimeout(function(){
//
//				$('[rel="'+chatbox+'"] .msg_body').find('.remove').remove();
//
//			},3500);

		}); //end of typing event.

		$(document).on('keypress', 'textarea' , function(e) {
			if (e.keyCode == 13 ) {
				// Remove disclaimer on mesage send
				msgWrap = $(this).parent().parent().parent().find('.msg_wrap');
				if(msgWrap.children($('.background')).length > 0){
					msgWrap.find('.background').hide();
				}
				var msg = $(this).val();
				toUser = $(this).parent().parent().parent().find('.msg_head span').text();
				var chatBoxFolderId = $(this).parent().parent().parent().find('.msg_folder_head').data('chatfolderid');

				var currentRoom = username+"-"+toUser+'-'+chatBoxFolderId;
				if(msg.trim().length != 0){
					socket.emit('chat-msg',{msg:msg,msgTo:toUser,date:Date.now(),getRoom:currentRoom,userImage:mainUserImage});
					$(this).val('');
					return false;

				}
			}
		});

		//receiving messages.
		socket.on('chat-msg',function(data){
			console.log(data);
			if($('.msg_box').hasClass(data.msgFrom+'-'+data.folderId) || data.msgFrom == username ){
				console.log('doo nothing');
			}else{
				var senderUsername = data.msgFrom;
				var userID = senderUsername+'_id';
				createChateArea(senderUsername,userID);
				//createChateArea(toUsername,userID,folderDetailsTitle,folderDetailsId,userImage);
				
			}
			//specify date formart
			var chatDate = moment(data.createdOn).format("MMMM Do YYYY, hh:mm:ss a");

			if(data.msgFrom == username){

				// find the to tab and display it

				var chatbox = $('.'+data.msgTo+'-'+data.folderId).attr("rel") ;
				var msgWrap = $('[rel="'+chatbox+'"] .msg_wrap');
				// if msg wrap is hidden add a blink when new msg comes in
				if(msgWrap.is(":hidden")){
					// find msg wrap head and add a blink to it
					var findWrapHead = msgWrap.parent().find('.msg_head');
					findWrapHead.addClass('chatblink');// make head to blink
				}

				// check if chatbox is open but input has lost focus
				if(msgWrap.is(":visible") && msgWrap.parent().find('.msg_input').is(':focus')){
					console.log('do nothing');
				}else{
					var findWrapHead = msgWrap.parent().find('.msg_head');
					findWrapHead.addClass('chatblink');// make head to blink
				}

				$('[rel="'+chatbox+'"] .msg_body').append('<div class="msg_chat_container msg-right"><div class="msg_chat_content"><div class="msg_chat_img_empty"></div><div class="msg_chat_text">'+data.msg+'</div></div><div class="msg_chat_date">'+chatDate+'</div></div>');
				$('[rel="'+chatbox+'"] .msg_body').find('.remove').remove();
				$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
			}else{
				// add sound to the user who gets the message
				$('#chatAudio')[0].play();
				var chatbox = $('.'+data.msgFrom+'-'+data.folderId).attr("rel") ;
				var msgWrap = $('[rel="'+chatbox+'"] .msg_wrap');
				imageurl = $('.'+chatbox).data('userimage');
				// if msg wrap is hidden add a blink when new msg comes in
				if(msgWrap.is(":hidden")){

					// find msg wrap head and add a blink to it
					var findWrapHead = msgWrap.parent().find('.msg_head');
					findWrapHead.addClass('chatblink');// make head to blink
				}
				// check if chatbox is open but input has lost focus
				if(msgWrap.is(":visible") && msgWrap.parent().find('.msg_input').is(':focus')){
					console.log('do nothing');
				}else{
					var findWrapHead = msgWrap.parent().find('.msg_head');
					findWrapHead.addClass('chatblink');// make head to blink
				}
				//else find the to client tab and and paste message

				$('[rel="'+chatbox+'"] .msg_body').append('<div class="msg_chat_container msg-left"><div class="msg_chat_content"><div class="msg_chat_img">'+'<img src="'+imageurl+'"/></div><div class="msg_chat_text">'+data.msg+'</div></div><div class="msg_chat_date">'+chatDate+'</div></div>');
				$('[rel="'+chatbox+'"] .msg_body').find('.remove').remove();
				$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
			}

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
		socket.on('set-join-room',function(room,senderUsername,roomName,userImage){

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
			var splitRoomName = roomName.split('-')

			var getFolderDetailsUrl = $('body').data('getfolderdetailsurl');
			$.post(getFolderDetailsUrl,{folderId:splitRoomName[2]},function(result){
				createChateArea(senderUsername,userID,result.title,result.id);
				//event to get chat history affter adding usuer to specific room .
				socket.emit('old-chats-init-for-join-request',{room:roomId,username:username,msgCount:msgCount,sender:senderUsername,folderId:result.id,userImage:userImage});
				;

			});
			// get the reciver chat box and add roomid
			getRel = $('.'+senderUsername+'-'+splitRoomName[2]).attr('rel');
			$(document).find('.'+getRel).attr('data-roomid',roomId);

		});
		//end of set-join-room event.

		// this area would recive a request from another client to join a room, this would be done scilently  the client would get the message and request that the server adds a user to the room, after which old message should be pulled and rendered
		socket.on('join-room',function(room,from,roomName,userImage){
		console.log("roomId : "+room);
		socket.emit('join-room',room,from,roomName,userImage);
		}); //end of set-room event.

	});//end of function.

});
