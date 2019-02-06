var express = require('express');
var router = express.Router();

var auth = require('../../middlewares/auth.js');


module.exports.controller = function(app){

  //route for chat
  app.get('/chat',auth.checkLogin,function(req,res){

    res.render('Chat-Application',
                {
                  title:"Chat Home",
                  user:req.session.user,
                  chat:req.session.chat
                });
	  console.log(req.session.user);
	  
  });

  app.use(router);

}//Chat controller end.
