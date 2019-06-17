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
			//ioTask.emit('task title', msg);
			socket.broadcast.emit('task title',msg); 
		});
		socket.on('task status', function(status){
			console.log(status);
			ioTask.emit('task status', status); 
		});
		socket.on('task delete', function(taskid){
			console.log(taskid);
			//ioTask.emit('task delete', msg);
			socket.broadcast.emit('task delete', taskid); 
		});
		socket.on('task assignee', function(assigneeArray){
			console.log(assigneeArray);
			ioTask.emit('task assignee', assigneeArray); 
		});
	})


}