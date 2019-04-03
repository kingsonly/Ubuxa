var express = require('express');
var app = express();
var http = require('http').Server(app);
var mongoose = require('mongoose');
var mysql = require('mysql');
var bodyParser = require('body-parser');
var cookieParser = require('cookie-parser');
var session = require('express-session');
var mongoStore = require('connect-mongo')(session);
var methodOverride = require('method-override');
var path = require('path');
var fs = require('fs');
var logger = require('morgan');

//port setup
var port = process.env.PORT || 4000;

//socket.io



require('./libs/chat.js').sockets(http);
require('./libs/remark.js').remarkSockets(http);
require('./libs/task.js').taskSockets(http);
app.use(logger('dev'));

//db connection
var dbPath = "mongodb://localhost/socketChatDB";
mongoose.connect(dbPath);
mongoose.connection.once('openUri',function(){
  console.log("Database Connection Established Successfully.");
});



var con = mysql.createConnection({
	  host: "localhost",
	  user: "root",
	  password: "",
	  database: "premux_main"
  });
//session setup
var sessionInit = session({
                    name : 'userCookie',
                    secret : '9743-980-270-india',
                    resave : true,
                    httpOnly : true,
                    saveUninitialized: true,
                    store : new mongoStore({mongooseConnection : mongoose.connection}),
                    cookie : { maxAge : 80*80*800 }
                  });

app.use(sessionInit);


//parsing middlewares
app.use(bodyParser.json({limit:'10mb',extended:true}));
app.use(bodyParser.urlencoded({limit:'10mb',extended:true}));
app.use(cookieParser());

//including models files.
fs.readdirSync("./app/models").forEach(function(file){
  if(file.indexOf(".js")){
    require("./app/models/"+file);
  }
});




//app level middleware for setting logged in user.

var userModel = mongoose.model('User');

app.use(function(req,res,next){



if(req.session && req.session.user){

	  con.connect(function(err) {
  if (err){
	 console.log('mysqlError:' + err)
  }
  con.query("SELECT username FROM tm_user WHERE username = '"+req.session.user.email+"' LIMIT 1", function (err,user) {
    if (err) {
          console.log("Error : " + err);
        } else {
          if(user){
			  console.log('this is the users loged'+req.user);
        req.user = user;
        delete req.user.password;
				req.session.user = user;
        delete req.session.user.password;
				next();
			}
        }
  });
});}
	else{
		next();
	}

});//end of set Logged In User.

//route for login
app.post('/api',function(req,res){

  //var epass = encrypt.encryptPassword(req.body.password);
    con.connect(function(err) {
        if (err){
            console.log(err)
        }
    if(!req.body.email) {
        return res.status(400).send({
          success: 'false',
          message: 'email is required'
        });
      }

con.query("SELECT * FROM tm_user WHERE username = '"+req.body.email+"' LIMIT 1", function (err, result) {
  if(err){

      console.log(err + 'we have an error');
      return res.status(500).send({
        success: 'true',
        message: 'error in connection',
      })
    }
    else if(result == null || result == undefined || result == ""){

      console.log(result + 'this user could not be found in the db1');
      return res.status(201).send({
        success: 'true',
        message: 'username not found',

      })
    }
    else{
      req.user = result[0];

      req.session.user = result[0];
      delete req.session.user.password;
      // res.redirect('/chat');
      console.log(req.session.user.username + 'user loged');

      const response = {
        response: result[0]
      }

      return res.status(200).send({
        success: 'true',
        message: 'connected',
        response
      })

    }
});
});

});


http.listen(port,function(){
  console.log("Chat App started at port :" +port);
});
