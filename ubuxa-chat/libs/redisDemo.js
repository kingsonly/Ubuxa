// redisDemo.js
var redis = require('redis');
const { Expo } = require('expo-server-sdk');
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
    // Create a new Expo SDK client
    let expo = new Expo();  

  	if(data !== null){
      // Create the messages that you want to send to clents
      let messages = [];
      let somePushTokens = ['ExponentPushToken[_Af6dYHl1zr1JIqq_KTAI7]']
      for (let pushToken of somePushTokens) {
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
          body: data[1],
          data: { body: data[1] },
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

  		ioRedis.emit('redis message', data[1]);
  	}

  client.keys('*', function (err, keys) {
  if (err) return console.log(err);
  console.log('keys', keys)
  ioRedis.emit('redis subscribers', keys);
  });


    
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