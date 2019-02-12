var express = require('express');
var mongoose = require('mongoose');
var bodyParser = require('body-parser');
var app = express();
var http = require('http');
var socket = require('socket.io');

var dbUrl = "mongodb://localhost:27017/mydb";
var Message = mongoose.model('Message',{ name : String, message : String,})

var server = http.createServer(app).listen(3000, function(){
  console.log("Express server listening on port " + app.get('port'));
});

var io = socket.listen(server);

io.on('connection', () =>{
 console.log('a user is connected')
})

app.use(express.static(__dirname));

mongoose.connect(dbUrl , (err) => { 
   console.log('mongodb connected',err);
})


var bodyParser = require('body-parser');
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({extended: false}));

app.get('/messages', (req, res) => {
  Message.find({},(err, messages)=> {
    res.send(messages);
  })
});

app.post('/messages', (req, res) => {
  var message = new Message(req.body);
  message.save((err) =>{
    if(err)
      sendStatus(500);
	io.emit('message', req.body);
    res.sendStatus(200);
	  
  })
})

