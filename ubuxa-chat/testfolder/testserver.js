var server     = require('http').createServer(),
    io         = require('socket.io')(server),
    port       = 3000;


io.on('connection', function (socket){
    var nb = 0;
	console.log('A user connected');
	
	socket.send('Sent a message 4seconds after connection!');


    socket.on('broadcast', function (message) {
        ++nb;
        // send to all connected clients
        io.sockets.emit("broadcast", message);
		console.log('broadcast');
    });

    socket.on('disconnect', function () {
       console.log('disconnected');
    });
});

server.listen(port);