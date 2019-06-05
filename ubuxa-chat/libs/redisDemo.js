// redisDemo.js
var redis = require('redis');
var client = redis.createClient(); // this creates a new client

module.exports.redisSocket = function(http) {
var ioRedis = io.of('/redis');

client.on('connect', function() {
    console.log('Redis client connected');
});

client.on('error', function (err) {
    console.log('Something went wrong ' + err);
});
client.rpush('dataQueue', 'A string of data')
client.keys('*', function (err, keys) {
  if (err) return console.log(err);

  for(var i = 0, len = keys.length; i < len; i++) {
    console.log(keys[i]);
  }
});
client.lrange('user_message:33', 0, -1, function(error, data){
  if (error) { 
    console.error('There has been an error:', error);
    }
  console.log('We have retrieved data from the front of the queue:', data);
})

function waitForPush () {
  client.blpop('user_message:33',120, function(error, data){
    // do stuff
    if (error) { 
    console.error('There has been an error:', error);
    }
    
  	console.log('We have retrieved data from the front of the queue:', data);
    ioRedis.emit('redis message', data[1]);
    client.exists('user_message:33', function(err, reply) {
      if (reply === 1) {
        
      } else {
        console.log('empty')
      }
    })
    waitForPush();
  });
}

waitForPush ()

  //setting redis route
  

}