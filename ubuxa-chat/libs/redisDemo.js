// redisDemo.jsvar
// var app = require('express')();
var express = require('express');
var app = express();
var httpd = require('http').Server(app);
var redis = require('redis');
const { Expo } = require('expo-server-sdk');
var client = redis.createClient(); // this creates a new client
var mysql = require('mysql');
var subscriber = redis.createClient();
var con = mysql.createConnection({
//    host: "localhost",
//    user: "epsolun_ubuxa",
//    password: "ubuxa##99",
//    database: "premux_main"
    
    host: "localhost",
    user: "root",
    password: "", 
    database: "premux_main"
});
con.connect();
const util = require('util')
var router = express.Router();
var user_message_33 = 0;
module.exports.redisSocket = function(http) {
var ioRedis = io.of('/redis');

	function activityHistory(userId){
		client.lrange('user_message:'+userId, 0, -1, function(error, data){
              if (error) { 
                return console.error('There has been an error:', error);
              }
              console.log('trial',data)
              let arrayData = [];
              for(let i=0; i<data.length; i++){
                arrayData.push(new Promise(function(resolve, reject) {
                      client.hgetall(data[i], function(errors, datas){
                        if (errors) { 
                          return console.error('There has been an error:', error);
                        }
                        //console.log('these are the lrange data',datas)
                        resolve(datas)
                        
                        
                      })
                }))
                  
                  //arrayData.push(obj)
                  
              }
              
             // wait till all data requests will be finished
              Promise.all(arrayData).then(function(results) {
                  console.log(results);
                  setTimeout(function(){
                    console.log('time is out')
                      ioRedis.emit('messages', {res:results, id: userId});
                  }, 3000)
              });
              if(data !== null){
               // ioRedis.emit('messages', '456778');
              }
        })

	}


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




function waitForPush (id) {
  client.exists('user_message:'+id, function(err, reply) {
      if (reply === 1) {
          client.lrange('user_message:'+id, 0, -1, function(error, data){
              if (error) { 
                return console.error('There has been an error:', error);
              }
              
              //if(data !== null && data.length > user_message+'_'+id){
                client.hgetall(data[0], function(errors, datas){
                  console.log('We have retrieved data from the front of the queue:', datas);
                  ioRedis.emit('redis message', {res:datas, id: id});
					
                })
                
              //}
          })
        
      } else {
        console.log('empty')
      }
  })
} 

	
	ioRedis.on('connection', function(socket2) {
		
		socket2.on('get-users-redis-id',function(userId){
			waitForPush(userId);
		});
		
		socket2.on('get-activity-history',function(userId){
			activityHistory(userId);
		})
		
	})

	
subscriber.on("message", function (channel, message) {
  let data = JSON.parse(message);
  console.log(util.inspect(data, false, null, true ))
  let msg = data.message
 
  console.log(util.inspect(data, false, null, true ))
  let expo = new Expo(); 
  
  if(!msg.includes("found")){
    for(let id of data.subscribers) {
      if(id !== data.actor_id){
        con.query("SELECT * FROM tm_user_device_push_token WHERE user_id =" + id, function (err, result) {
          if (err) throw err;
          console.log('resl',result[0]);
          
          let tokens = [];
          for (var i = 0; i < result.length; i++) {
              tokens.push(result[i].push_token)
          }
        
          // Create the messages that you want to send to clents
          let messages = [];
          for (let pushToken of tokens) {
              // Each push token looks like ExponentPushToken[xxxxxxxxxxxxxxxxxxxxxx]

              // Check that all your push tokens appear to be valid Expo push tokens
              if (!Expo.isExpoPushToken(pushToken)) {
                console.error(`Push token ${pushToken} is not a valid Expo push token`);
                continue;
              }
              // Construct a message (see https://docs.expo.io/versions/latest/guides/push-notifications.html)
              messages.push({
                to: pushToken,
                sound: 'default',
                body: data.message,
                data: { 
                  body: data.message,
                  fromWhere: 'system'
                },
                channelId: 'mychannel',
                priority: 'high',
              })
          }

            // The Expo push notification service accepts batches of notifications so
          // that you don't need to send 1000 requests to send 1000 notifications. We
          // recommend you batch your notifications to reduce the number of requests
          // and to compress them (notifications with similar content will get
          // compressed).
          let chunks = expo.chunkPushNotifications(messages);
          let tickets = [];
          (async () => {
            // Send the chunks to the Expo push notification service. There are
            // different strategies you could use. A simple one is to send one chunk at a
            // time, which nicely spreads the load out over time:
            console.log('chunk', chunks)
            for (let chunk of chunks) {
              try {
                let ticketChunk = await expo.sendPushNotificationsAsync(chunk);
                console.log('ticket', ticketChunk, 'data', data);
                tickets.push(...ticketChunk);
                // NOTE: If a ticket contains an error code in ticket.details.error, you
                // must handle it appropriately. The error codes are listed in the Expo
                // documentation:
                // https://docs.expo.io/versions/latest/guides/push-notifications#response-format
              } catch (error) {
                console.error(error);
              }
            }
          })()
        });
      }
    }
  }
	//waitForPush (sess.email)
	console.log('we see this')
	ioRedis.emit('get-users-redis-id');
	
	
	
});

subscriber.subscribe("notification");


}




		