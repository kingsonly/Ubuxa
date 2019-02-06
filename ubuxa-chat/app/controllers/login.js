var express = require('express');
var mongoose = require('mongoose');
var mysql = require('mysql');

//middlewares
var auth = require('../../middlewares/auth.js');
var encrypt = require('../../libs/encrypt.js');

var router = express.Router();

var userModel = mongoose.model('User');

module.exports.controller = function(app){
	var con = mysql.createConnection({
	  host: "localhost",
	  user: "root",
	  password: "",
	  database: "premux_main"
  });

  //route for login
  router.get('/login',auth.loggedIn,function(req,res){
    res.render('login',
                {
                  title:"User Login",
                  user:req.session.user,
                  chat:req.session.chat
                });
  });

  //route for logout
  router.get('/logout',function(req,res){

    delete req.session.user;
    res.redirect('/user/login');

  });

  //route for login
  router.post('/api/v1/login',auth.loggedIn,function(req,res){

    var epass = encrypt.encryptPassword(req.body.password);
	    con.connect(function(err) {
  if (err){
	  console.log(err)
  }
  con.query("SELECT * FROM tm_user WHERE username = '"+req.body.email+"' LIMIT 1", function (err, result) {
    if(err){
        // res.render('message',
        //             {
        //               title:"Error",
        //               msg:"Some Error Occured During Login.",
        //               status:500,
        //               error:err,
        //               user:req.session.user,
        //               chat:req.session.chat
        //             });
				console.log(err + 'we have an error')
      }
      else if(result == null || result == undefined || result == ""){
        // res.render('message',
        //             {
        //               title:"Error",
        //               msg:"User Not Found. Please Check Your Username and Password.",
        //               status:404,
        //               error:"",
        //               user:req.session.user,
        //               chat:req.session.chat
        //             });

				console.log(result + 'this user could not be found in the db1')
      }
      else{
        req.user = result[0];

        req.session.user = result[0];
        delete req.session.user.password;
        // res.redirect('/chat');
				console.log(result + 'this user could not be found in the db')

      }
  });
});

    /*userModel.findOne({$and:[{'email':req.body.email},{'password':epass}]},function(err,result){
      if(err){
        res.render('message',
                    {
                      title:"Error",
                      msg:"Some Error Occured During Login.",
                      status:500,
                      error:err,
                      user:req.session.user,
                      chat:req.session.chat
                    });
      }
      else if(result == null || result == undefined || result == ""){
        res.render('message',
                    {
                      title:"Error",
                      msg:"User Not Found. Please Check Your Username and Password.",
                      status:404,
                      error:"",
                      user:req.session.user,
                      chat:req.session.chat
                    });
      }
      else{
        req.user = result;
        delete req.user.password;
        req.session.user = result;
        delete req.session.user.password;
        res.redirect('/chat');
      }
    });*/
  });

  app.use('/user',router);

} // login controller end
