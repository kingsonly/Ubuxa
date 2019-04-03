//var app = require('express')();
//var http = require('http').Server(app);
//var remarkio = require('socket.io');


module.exports.taskSockets = function(http) {
	

	//setting chat route
	var ioTask = io.of('/task');
	ioTask.on('connection', function(socket) {
		console.log('task got here');
		socket.on('task title', function(msg){
			console.log(msg);
			ioTask.emit('task title', msg); 
		});
		socket.on('task status', function(status){
			console.log(status);
			ioTask.emit('task status', status); 
		});
	})


}