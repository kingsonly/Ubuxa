// redisDemo.jsvar
// var app = require('express')();
var express = require('express');
var app = express();
var httpd = require('http').Server(app);
var redis = require('redis');
var client = redis.createClient(); // this creates a new client
var router = express.Router();

var user_message_33 = 0;
module.exports.redisSocket = function(http) {
var ioRedis = io.of('/redis');

console.log('this is redis server showing user id', sess.email)

client.lrange('user_message:'+sess.email, 0, -1, function(error, data){
              if (error) { 
                return console.error('There has been an error:', error);
              }
              let arrayData = [];
              for(let i=0; i<5 ; i++){
                arrayData.push(new Promise(function(resolve, reject) {
                      client.lrange(data[i]+':meta_message', 0, -1, function(errors, datas){
                        if (errors) { 
                          return console.error('There has been an error:', error);
                        }
                        resolve(datas)
                        //console.log('these are the lrange data',arrayData)
                        
                      })
                }))
                  
                  //arrayData.push(obj)
                  
              }
              
             // wait till all data requests will be finished
              Promise.all(arrayData).then(function(results) {
                  console.log(results);
                  setTimeout(function(){
                    console.log('time is out')
                      ioRedis.emit('messages', results);
                  }, 150000)
                  
              });
              if(data !== null){
               // ioRedis.emit('messages', '456778');
              }
        })
/*app.all('/curl', function(req, res) {
        console.log(req.body.iduser); // Lorem
        userId = 33;
        res.status(200).json({data:req.body}); // will give { name: 'Lorem',age:18'} in response
        client.lrange('user_message:33', 0, -1, function(error, data){
              if (error) { 
                return console.error('There has been an error:', error);
              }
              console.log('these are the lrange data',data)
              if(data !== null){
               // ioRedis.emit('messages', '456778');
              }
        })
    });*/



client.on('connect', function() {
    //console.log('Redis client connected');
});

client.on('error', function (err) {
    //console.log('Something went wrong ' + err);
});
client.rpush('dataQueue', 'A string of data')
client.keys('*', function (err, keys) {
  if (err) return console.log(err);

  for(var i = 0, len = keys.length; i < len; i++) {
    //console.log(keys[i]);
  }
});







function waitForPush () {
  client.exists('user_message:'+sess.email, function(err, reply) {
      if (reply === 1) {
          client.lrange('user_message:'+sess.email, 0, -1, function(error, data){
              if (error) { 
                return console.error('There has been an error:', error);
              }
              //console.log('We have retrieved data from the front of the queue:', data);
              if(data !== null && data.length > user_message_33){
                ioRedis.emit('redis message', data);
                user_message_33 = data.length
              }
          })
        
      } else {
        console.log('empty')
      }
      waitForPush();
  })
  
  /*client.blpop('user_message:33',120, function(error, data){
    // do stuff
    
    if (error) { 
    console.error('There has been an error:', error);
    }
    
  	console.log('We have retrieved data from the front of the queue:', data);
    if(data !== null){
        ioRedis.emit('redis message', data[1]);
      }
    client.exists('user_message:33', function(err, reply) {
      if (reply === 1) {
        
      } else {
        console.log('empty')
      }
    })
    waitForPush();
  });*/
}

//waitForPush ()

  //setting redis route
  

}