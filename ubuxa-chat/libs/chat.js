
var mongoose = require('mongoose');
var events = require('events');
var mysql = require('mysql');
var _ = require('lodash');
var eventEmitter = new events.EventEmitter();

//adding db models
require('../app/models/user.js');
require('../app/models/chat.js');
require('../app/models/room.js');

//using mongoose Schema models
var userModel = mongoose.model('User');
var chatModel = mongoose.model('Chat');
var roomModel = mongoose.model('Room');


//reatime magic begins here
module.exports.sockets = function(http) {

    var con = mysql.createConnection({
//		host: "localhost",
//		user: "epsolun_ubuxa",
//		password: "ubuxa##99",
//		database: "premux_main"
		
		host: "localhost",
		user: "root",
		password: "", 
		database: "premux_main"
	});
	con.connect();



//setting chat route
var ioChat = io.of('/chat');
var userStack = {}; // holds all the users from the mysql database
var oldChats, sendUserStack, setRoom;
var userSocket = {}; // holds all conected client details
var userSocketInstBuyUserName = {}; // this might not be needed any more

//socket.io magic starts here
ioChat.on('connection', function(socket) {
    console.log("socketio chat connected.");

	//function to get user name, this would be emited from the client and recieved on the server
	socket.on('set-user-data', function(username) {
		console.log(username+ "  logged In 1");
		//storing variable.
		socket.username = username;
		userSocket[socket.username] = socket.id;
		userSocketInstBuyUserName[socket.username] = socket;
		socket.broadcast.emit('broadcast',{ description: socket.username + ' Logged In'}); //this would no longer be needed
		//getting all users list
		eventEmitter.emit('get-all-users');
		//sending all users list. and setting if online or offline.
		sendUserStack = function() {
			for (i in userSocket) {
				for (j in userStack) {
					if (j == i) {
						userStack[j] = "Online";
					}
				}
			}
			//for popping connection message.
			
			ioChat.emit('onlineStack', userStack);
			
		} //end of sendUserStack function.
			
	}); //end of set-user-data event.

	//setting room.
	socket.on('set-room', function(room) {
		//getting room data.
		var splitRoomName = room.name1.split('-');
		var folderId = splitRoomName['2'];
		getRoomData(room)
		//eventEmitter.emit('get-room-data', room);
		//setting room and join.
        setRoom = function(roomId) {
            socket.room = roomId;
            console.log("roomId : " + socket.room + 'touser = '+ room.toUser);
            socket.join(roomId);
            ioChat.to(userSocket[socket.username]).emit('set-room', socket.room,room.toUser+'-'+folderId,folderId);
        };

	}); //end of set-room event.


	//emits event to read old-chats-init from database.
	socket.on('old-chats-init', function(data) {
		chatModel.find({})
		.where('room').equals(data.room)
		.sort('-createdOn')
		.skip(data.msgCount)
		.lean()
		.limit(5)
		.exec(function(err, result) {
			if (err) {
				console.log("Error : " + err);
			} else {
				//calling function which emits event to client to show chats.
				oldChats(result, data.username, data.room,data.sender,data.folderId);

			}
		});
	});

	//emits event to read old-chats-init from database.
	socket.on('old-chats-init-for-join-request', function(data) {
		chatModel.find({})
		.where('room').equals(data.room)
		.sort('-createdOn')
		.skip(data.msgCount)
		.lean()
		.limit(5)
		.exec(function(err, result) {
			if (err) {
				console.log("Error : " + err);
			} else {
				//calling function which emits event to client to show chats.
				oldChatsNewJoin(result, data.username, data.room,data.sender,data.folderId,data.userImage);
			}
		});
		// eventEmitter.emit('read-chat-join-request', data);
	});

	//emits event to read old chats from database.
	socket.on('old-chats', function(data) {
		// here instead of emiting read chat, make read chat a function
		eventEmitter.emit('read-chat', data);
	});

	//sending old chats to client.
	oldChats = function(result, username, room,toUser,folderId) {
        console.log('i am sender but i am the tab to be updated '+toUser);
		ioChat.to(userSocket[username]).emit('old-chats', {
            result: result,
			room: room,
			sender: toUser,
			folderId: folderId,
			username: username,
		});
	}

	//showing msg on typing.
	socket.on('typing', function(data) {
		//socket.to(socket.room).broadcast.emit('typing', socket.username + " : is typing...");
        // send a message to the other person on the other end of the chat
        // as such the emit from client would send an object with userTo and userFrom
        // userTo would be added in the userSocket array to send it to the other user
        // while user from would be attached to the message which would be sent back to the client
        // userFrom would also be used to locate the tab and the folder to which this message would be rendered.
        var splitTouser = data.userTo.split('-');
        console.log(data.userTo)
		ioChat.to(userSocket[splitTouser[0]]).emit('typing', {msg:data.userFrom + " : is typing...",updateChatBox:data.userFrom+'-'+splitTouser[1]});
        //ioChat.to(userSocket[splitTouser[0]]).emit('typing', {msg:data.msg,updateChatBox:data.userFrom+'-'+splitTouser[1]});
	});

	//for showing chats.
	socket.on('chat-msg', function(data) {
		var folderId = data.getRoom.split('-');
		console.log('this is folderid split');
		console.log(folderId);
	//emits event to save chat to database.
		roomId = '';
		roomModel.find({
			$or: [{
				name1: data.getRoom
			}, {
				name2: data.getRoom
			}, ]
		}, function(err, result) {
			if (err) {
				console.log("Error : " + err);
			} else {
				var jresult = JSON.parse(JSON.stringify(result));
				//setRoom(jresult[0]._id); //calling setRoom function.

				roomId = jresult[0]._id;
				//userSocketInstBuyUserName[data.msgTo].join(roomId)
				console.log('romeid = '+ roomId); 

				//console.log('number of users = '+ count)
				from = socket.username; //this is the user who started the socket conection

				ioChat.in(roomId).clients((err, clients) => {
					console.log('a list of all connected clients');
					console.log(clients); // an array containing socket ids in 'room'
					console.log(userSocket[data.msgTo]+' this is an id of the from'); // an array containing socket ids in 'room'
					console.log(clients.indexOf(userSocket[data.msgTo]) + 'yes to is in room'); // an array containing socket ids in 'room3'

					if(clients.indexOf(userSocket[data.msgTo]) > -1){

                        if(clients.indexOf(userSocket[data.msgFrom]) > -1){
                            console.log('go ahead');
                        }else{
                            socket.join(roomId);
                            console.log('i joined now');
                            console.log(clients);
                        }
						//ioChat.to(userSocket[data.msgTo]).emit('join-room', roomId,from);
					}else{
						ioChat.to(userSocket[data.msgTo]).emit('join-room', roomId,from,data.getRoom,data.userImage);
						console.log('go ahead2');
					}

				});

				eventEmitter.emit('save-chat', {
					msgFrom: socket.username,
					msgTo: data.msgTo,
					msg: data.msg,
					//room: socket.room,
					room: roomId,
					date: data.date
				});
				//emits event to send chat msg to all clients.
				ioChat.to(roomId).emit('chat-msg', {
					msgFrom: socket.username,
					msg: data.msg,
					msgTo: data.msgTo,
					date: data.date,
					folderId: folderId[2],
					userImage: data.userImage,
					roomId: roomId,
				});
			}
		} //end of else.
		);

	});

	//	this area was added by kingsley of epsolun to make changes to lib

	//reading chat from database for new join request.
	eventEmitter.on('read-chat-join-request', function(data) {
		chatModel.find({})
		.where('room').equals(data.room)
		.sort('-createdOn')
		.skip(data.msgCount)
		.lean()
		.limit(5)
		.exec(function(err, result) {
			if (err) {
				console.log("Error : " + err);
			} else {
				//calling function which emits event to client to show chats.
				oldChatsNewJoin(result, data.username, data.room,data.sender);
			}
		});
	}); //end of reading chat from database for new join request.

	oldChatsNewJoin = function(result, username, room,sender,folderId,userImage) {
		console.log('oldChatsNewJoin ' + username)

		ioChat.to(userSocket[username]).emit('old-chats-for-invite', {
			result: result,
			room: room,
			sender: sender,
			folderId: folderId,
			userImage: userImage,
		});
	}

	// start the join room sent by the client
	socket.on('join-room', function(room,from,roomName,userImage) {
		socket.join(room);
		ioChat.to(userSocket[socket.username]).emit('set-join-room', room,from,roomName,userImage);
	})
	
	socket.on('leave-room', function(data) {
		console.log('lv room ' + data.room)
		socket.leave(data.room); 
	})
	//	changes by kingsley of epsolun ends here

	//for popping disconnection message.
	socket.on('disconnect', function() {
		console.log(socket.username+ "  logged out");
		socket.broadcast.emit('broadcast',{ description: socket.username + ' Logged out'});
		console.log("chat disconnected.");
		_.unset(userSocket, socket.username);
		userStack[socket.username] = "standby";
		ioChat.emit('onlineStack', userStack);
	}); //end of disconnect event.

}); //end of io.on(connection).
//end of socket.io code for chat feature.

//database operations are kept outside of socket.io code.
//saving chats to database.
eventEmitter.on('save-chat', function(data) {
	// var today = Date.now();
	var newChat = new chatModel({
		msgFrom: data.msgFrom,
		msgTo: data.msgTo,
		msg: data.msg,
		room: data.room,
		createdOn: data.date
	});

	newChat.save(function(err, result) {
		if (err) {
			console.log("Error : " + err);
		} else if (result == undefined || result == null || result == "") {
			console.log("Chat Is Not Saved.");
		} else {
			console.log("Chat Saved.");
			//console.log(result);
		}
	});

}); //end of saving chat.

//reading chat from database.
eventEmitter.on('read-chat', function(data) {

	chatModel.find({})
	.where('room').equals(data.room)
	.sort('-createdOn')
	.skip(data.msgCount)
	.lean()
	.limit(5)
	.exec(function(err, result) {
		if (err) {
			console.log("Error : " + err);
		} else {
			//calling function which emits event to client to show chats.
			oldChats(result, data.username, data.room,data.sender);
		}
	});
}); //end of reading chat from database.

//reading chat from database for join request.



//listening for get-all-users event. creating list of all users.
eventEmitter.on('get-all-users', function() {

	
	con.query("SELECT username FROM tm_user", function (err, result) {
			if (err) {
				console.log("Error : " + err);
				ioChat.emit('wrong', err);
			} else {
				//console.log(result);
				for (var i = 0; i < result.length; i++) {
					userStack[result[i].username] = "Offline";
				}
				//console.log("stack "+Object.keys(userStack));
				for (i in userSocket) {
					for (j in userStack) {
						if (j == i) {
							userStack[i] = "Online";
						}
					}
				}
				ioChat.emit('fromconection', userStack);
				ioChat.emit('onlineStack', userStack);
			}
		});
	

}); //end of get-all-users event.
	
	
function getAllUsers() {

	
	con.query("SELECT username FROM tm_user", function (err, result) {
			if (err) {
				console.log("Error : " + err);
				ioChat.emit('wrong', err);
			} else {
				//console.log(result);
				for (var i = 0; i < result.length; i++) {
					userStack[result[i].username] = "Offline";
				}
				//console.log("stack "+Object.keys(userStack));
				for (i in userSocket) {
					for (j in userStack) {
						if (j == i) {
							userStack[i] = "Online";
						}
					}
				}
				ioChat.emit('fromconection', userStack);
				ioChat.emit('onlineStack', userStack);
			}
		});
	

}

//listening get-room-data event.
function getRoomData(room) {
	roomModel.find({
		$or: [{
			name1: room.name1
		}, {
			name1: room.name2
		}, {
			name2: room.name1
		}, {
			name2: room.name2
		}]
	}, function(err, result) {
		if (err) {
			console.log("Error : " + err);
		} else {
			if (result == "" || result == undefined || result == null) {
				var today = Date.now();
				newRoom = new roomModel({
					name1: room.name1,
					name2: room.name2,
					lastActive: today,
					createdOn: today
				});

				newRoom.save(function(err, newResult) {
					if (err) {
						console.log("Error : " + err);
					} else if (newResult == "" || newResult == undefined || newResult == null) {
						console.log("Some Error Occured During Room Creation.");
					} else {
						setRoom(newResult._id); //calling setRoom function.
					}
				}); //end of saving room.

			} else {
				var jresult = JSON.parse(JSON.stringify(result));
				setRoom(jresult[0]._id); //calling setRoom function.
			}
		} //end of else.
	}); //end of find room.
}; //end of get-room-data listener.
//end of database operations for chat feature.

//
//

//listening get-room-data event.
eventEmitter.on('get-room-data', function(room) {
	roomModel.find({
		$or: [{
			name1: room.name1
		}, {
			name1: room.name2
		}, {
			name2: room.name1
		}, {
			name2: room.name2
		}]
	}, function(err, result) {
		if (err) {
			console.log("Error : " + err);
		} else {
			if (result == "" || result == undefined || result == null) {
				var today = Date.now();
				newRoom = new roomModel({
					name1: room.name1,
					name2: room.name2,
					lastActive: today,
					createdOn: today
				});

				newRoom.save(function(err, newResult) {
					if (err) {
						console.log("Error : " + err);
					} else if (newResult == "" || newResult == undefined || newResult == null) {
						console.log("Some Error Occured During Room Creation.");
					} else {
						setRoom(newResult._id); //calling setRoom function.
					}
				}); //end of saving room.
			} else {
				var jresult = JSON.parse(JSON.stringify(result));
				setRoom(jresult[0]._id); //calling setRoom function.
			}
		} //end of else.
	}); //end of find room.
}); //end of get-room-data listener.
//end of database operations for chat feature.







//to verify for unique username and email at signup.
//socket namespace for signup.
var ioSignup = io.of('/signup');

var checkUname, checkEmail; //declaring variables for function.

ioSignup.on('connection', function(socket) {
console.log("signup connected.");

//verifying unique username.
socket.on('checkUname', function(uname) {
eventEmitter.emit('findUsername', uname); //event to perform database operation.

}); //end of checkUname event.

//function to emit event for checkUname.
checkUname = function(data) {
ioSignup.to(socket.id).emit('checkUname', data); //data can have only 1 or 0 value.
}; //end of checkUsername function.

//verifying unique email.
socket.on('checkEmail', function(email) {
eventEmitter.emit('findEmail', email); //event to perform database operation.
}); //end of checkEmail event.

//function to emit event for checkEmail.
checkEmail = function(data) {
ioSignup.to(socket.id).emit('checkEmail', data); //data can have only 1 or 0 value.
}; //end of checkEmail function.

//on disconnection.
socket.on('disconnect', function() {
console.log("signup disconnected.");
});

}); //end of ioSignup connection event.

//database operations are kept outside of socket.io code.
//event to find and check username.
eventEmitter.on('findUsername', function(uname) {


con.connect(function(err) {
if (err){
console.log('mysqlError:' + err)
}
con.query("SELECT username FROM tm_user WHERE username = '"+uname+"' LIMIT 1", function(err, result) {
if (err) {
console.log("Error : " + err);
} else {
//console.log(result);
if (result == "") {
checkUname(1); //send 1 if username not found.
} else {
checkUname(0); //send 0 if username found.
}
}
});
});

}); //end of findUsername event.

//event to find and check username.
eventEmitter.on('findEmail', function(email) {

/*userModel.find({
'email': 'kingsonly13c@gmail.com'//email
}, function(err, result) {
if (err) {
console.log("Error : " + err);
} else {
//console.log(result);
if (result == "") {
checkEmail(1); //send 1 if email not found.
} else {
checkEmail(0); //send 0 if email found.
}
}
});*/
console.log('dont know the use yet') 

}); //end of findUsername event.


return io;

};
