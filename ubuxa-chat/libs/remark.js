//var app = require('express')();
//var http = require('http').Server(app);
//var remarkio = require('socket.io');


module.exports.remarkSockets = function(http) {
	

	//setting chat route
	var ioRemark = io.of('/remark');
	ioRemark.on('connection', function(socket) {
		console.log('we got here');
		socket.on('chat message', function(msg){
			var value1 = msg.test;
			var value2 = msg.test2;
			console.log(value1);
		    ioRemark.emit('chat message', value1,value2); 
		});
	})


}