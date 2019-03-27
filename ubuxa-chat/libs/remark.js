//var app = require('express')();
//var http = require('http').Server(app);
//var remarkio = require('socket.io');


module.exports.remarkSockets = function(http) {
	

	//setting chat route
	var ioRemark = io.of('/remark');
	ioRemark.on('connection', function(socket) {
		console.log('we got here');
		socket.on('chat message', function(msg){
			console.log('message: ' + msg);
		    ioRemark.emit('chat message', msg);
		});
	})


}