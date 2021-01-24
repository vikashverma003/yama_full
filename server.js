'use strict';

require('dotenv').config();

var app 	= require('express')();
const path 	= require('path');
var server 	= require('http').createServer(app);
var io 		= require('socket.io').listen(server);
var mysql 	= require('mysql');
var Redis 	= require('ioredis');
var request = require('request');
// var redisClient = Redis.createClient();
var redisClient = new Redis();
let new_redis=require('redis');
console.log("DATABASE CONFIGURATIONS", {host: process.env.DB_HOST,
            user: process.env.DB_USERNAME,
            password: process.env.DB_PASSWORD,
            database: process.env.DB_DATABASE,
port: process.env.DB_PORT})
/*********** Mysql Connection ***********/
var db_config = {
            host: process.env.DB_HOST,
            user: process.env.DB_USERNAME,
            password: process.env.DB_PASSWORD,
            database: process.env.DB_DATABASE,
            //port: process.env.DB_PORT
        };
var con;

function handleDisconnect() {
    con = mysql.createConnection(db_config); // Recreate the connection, since the old one cannot be reused.
    con.connect(function(err) {              // The server is either down
        if(err)
        {                                    // or restarting (takes a while sometimes).
            console.log('error when connecting to db:', err.message);
            setTimeout(handleDisconnect, 2000); // We introduce a delay before attempting to reconnect,
        }
        else
        {
            console.log("DB Connected!");
        }                                     // to avoid a hot loop, and to allow our node script to
    });                                     // process asynchronous requests in the meantime.

    con.on('error', function(err) {
        //console.log('db error', err);
        if(err.code === 'PROTOCOL_CONNECTION_LOST')
        {
             //Connection to the MySQL server is usually lost due to either server restart, or a connnection idle timeout (the wait_timeout server variable configures this)
            handleDisconnect();
        }
        else
        {
           console.log("Mysql Error - ",err.message);
            throw err;
        }
    });
}
handleDisconnect();
/*********** Mysql Connection ***********/

var port_number = process.env.SOCKET_IO_PORT || 8000;

server.listen(port_number, function(){
    console.log("Listening on localhost:"+port_number)
});

//var redisClients = Redis.createClient();
//redisClients.subscribe('message');

// io.emit("trackingeventsend", {
//
//
//     });
/*var redisClient = Redis.createClient({
  sentinels: [{ host: process.env.REDIS_HOST, port: process.env.REDIS_PORT }],
  password: process.env.REDIS_PASSWORD,
  sentinels: null
  });*/
  
io.on('connection',async function (socket) {
	
	let new_client_web = new_redis.createClient();
	new_client_web.subscribe('channel1_'+socket.id);
	new_client_web.on("message", function(channel, data) {
       
	   console.log(data);
     io.emit('doctorStatus', data);
	 
   });
   
   //For Accept request or decline request and end chat
   let new_client_request = new_redis.createClient();
	new_client_request.subscribe('channel2_'+socket.id);
	new_client_request.on("message", function(channel, data) {
       console.log('Accept');
	   console.log(data);
     io.emit('acceptChat', data);
	 
   });
   //Reject Chat
   let new_client_decline = new_redis.createClient();
	new_client_decline.subscribe('channel3_'+socket.id);
	new_client_decline.on("message", function(channel, data) {
        console.log('Reject');
	   console.log(data);
     io.emit('declineChat', data);
	 
   });
   
   //End Chat
   let new_client_end = new_redis.createClient();
	new_client_end.subscribe('channel4_'+socket.id);
	new_client_end.on("message", function(channel, data) {
        console.log('End');
	   console.log(data);
     io.emit('endChat', data);
	 
   });
   //io.to(socket_id).emit('app_notification_count', notif_data);
   //Send request by patient
   
   let new_client_req = new_redis.createClient();
	new_client_req.subscribe('channel5_'+socket.id);
	new_client_req.on("message", function(channel, data) {
        console.log('req');
	   console.log(data);
     io.emit('endChat', data);
	 
   });
   
   //Same Time
   let new_client_same = new_redis.createClient();
	new_client_same.subscribe('channel6_'+socket.id);
	new_client_same.on("message", function(channel, data) {
        console.log(socket.id);
	   console.log(data);
     //io.emit('sameTime', data);
	io.to(socket.id).emit('sameTime', data);
	 
   });
   
   
   
   
      let new_client = new_redis.createClient();
      console.log('socket',socket)
      let token = socket.handshake.query.token;
       console.log(token);
      let data1 = await checkVerifyToken(token);
      //console.log("data1",data1);
      // console.log(data1,socket);
      // if ( data1.status == 401 ) {
      //     await socket.emit('socketError',{status:401,message:'unauth'});
      //     return;
      // }
      let findUser = data1.user;
      // console.log("asd",findUser);
     // console.log(findUser.id);
      await new_client.set(findUser.id,socket.id);

      await socket.emit('socketConnected', {
          status: 200,
          message: 'ADDED_TO_SOCKET',
          data: {socketId: socket.id}
      });
	  
	 
	  
	  con.query("update `users` set socket_id='"+socket.id+"' where id='"+findUser.id+"'", function(err, res){
                global.is_read = 0;
				if(err)
                       {
                           console.log(err.message);

                       }
				
            });
			
			
		
 
 
			
			
   /*redisClients.subscribe('channel_1_'+socket.id);
    redisClients.on("message", function(channel, data) {
        var notif_data = JSON.parse(data);
       console.log("channel data ------",notif_data);
    });*/
	  
	  
	  
      //console.log(socket.handshake.query.accessToken);
      socket.on("trackingeventsend", async function (data) {

             console.log("data");
             await new_client.get(data.user_id,function(err, reply) {
    // reply is null when the key is missing
    console.log(data);

     io.to(reply).emit('trackingeventrec', data);

    console.log(findUser.name + " connected");
    });
    });
    socket.on('disconnect', async function () {

        let keys = await new_client.keys('*');
        let user="";

        for(let i=0; i<keys.length; i++){

            let getValue = await new_client.get(keys[i]);
            if( getValue == socket.id ){
                user = keys[i];
                break;
            }
        }
        //console.log(user + " disconnected");

        await io.sockets.emit('broadcast',{userId:user,isOnline:false});
        if(user){
            await new_client.del(user.toString());
            //await DAO.update(Models.User,{_id:user},{$set:{isOnline:false}},{lean:true,new:true})
        }
    });

    socket.on("washerRevert", async function(data) {

          //console.log('in event message');
          //console.log("Sending1: " + data);
       
    });

    socket.on('send-message', function(data, callback)
    {

        // console.log("message");
         console.log(data);
      
        // console.log("send-message");
        if(!data.sender_id){
            io.sockets.connected[socket.id].emit('sendMsgResp', {"error": 'User Id is Required'});
            console.log('Sender Id is Required');
        }
        else if(!data.receiver_id){
            io.sockets.connected[socket.id].emit('sendMsgResp', {"error": 'Receiver User Id is Required'});
            console.log('Receiver Id is Required');
        }
        else
        {

            con.query("select * from users where id="+data.receiver_id+"", function(err, res){
                global.is_read = 0;
                if(err)
                {
                    con.end();
                    console.log(err);
                    global.is_read = 2;
                }
                else
                {
                    if(res.length > 0)
                    {
                      console.log(res);
					   

                          
                        
                        
                    }
                    else
                    {
                        global.is_read = 2;
                    }
                }

                request({
                    url: process.env.APP_URL + "/api/send-chat-message",
                    method: "POST",
                    headers: { 'Accept' : 'application/json', 'Authorization' : token },
                    json: true,
                    body: {user_id: data.sender_id, other_user_id: data.receiver_id, message: data.message,message_type:data.message_type,id:data.id,image:data.image, assignment: data.assignment_id,message_file:data.message_file}
                }, function (error, response, body){

                    //console.log("body:",body);
                    //console.log("error:",error);

				new_client.get(data.receiver_id,function(err, reply) {

               //console.log("reply",reply);
			   
                io.to(reply).emit('sendMsgResp', body.response);
               
             });
			   

               

                    



                });
            });

        }
    });
	
	
	//End Chat
	
	
	 socket.on('end-chat', function(data, callback)
    {

        // console.log("message");
         //console.log(data);
      
       if(!data.request_id){
            io.sockets.connected[socket.id].emit('sendMsgResp', {"error": 'patient Id is Required'});
            //console.log('Request Id is Required');
        }
        else
        {

            con.query("select * from users where id="+data.receiver_id+"", function(err, res){
                global.is_read = 0;
               

                request({
                    url: process.env.APP_URL + "/api/endChat",
                    method: "POST",
                    headers: { 'Accept' : 'application/json', 'Authorization' : token },
                    json: true,
                    body: {request_id: data.request_id}
                }, function (error, response, body){

                    //console.log("body:",body);
                    //console.log("error:",error);

				new_client.get(data.receiver_id,function(err, reply) {

               //console.log("reply",body.response);
			   
                io.to(reply).emit('ChatClose', body.response);
               
             });
                });
            });
        }
    });
	
	//Close Chat
	
	
	
	
	
	
	
	
	
	
	
	
	

    socket.on("requestUpdate", async function (data) {

           //console.log("data");
  await new_client.get(data.user_id,function(err, reply) {
  // reply is null when the key is missing
  //console.log(data);

   io.to(reply).emit('requestUpdate', data);

  //console.log(findUser.name + " connected");
  });
  });
  
  
/*let new_client1 = new_redis.createClient();
new_client1.subscribe('message');

console.log('=======dfgdfg==============');

new_client1.on("message", function(channel, data) {
  console.log('======================================');
   
});*/
  
  
  
  
 /* redisClient.subscribe('message');
redisClient.subscribe('WebPayResp');

redisClient.on("message", function(channel, data) {
  console.log('======================================');
   if(channel == "WebPayResp") // Send WebPay Plus Payment Response to Mobile
   {
       var respData = JSON.parse(data);
       console.log("Sending WebPay Payment Response to Socket:"+respData.socket_id);
       io.sockets.to(respData.socket_id).emit('WebPayResp', respData);
   }
   else
   {
       var tempdata = JSON.parse(data);
       var ids = JSON.parse(tempdata.socket_ids);
       console.log("New Message in queue "+ typeof ids, ', ', ids);
       ids.forEach(function(id){
               try{
                   console.log('sending to socket - '+id);
                   io.sockets.to(id).emit('message', tempdata);
               }   catch(e)   {
                   console.log('Socket Emit Error - '+e);
               }
       });
   }
});*/

  
  
  
  
  
  
});


const checkVerifyToken =  async (token)  => {
  // console.log('token',token)
    return new Promise((resolve, reject) => {
        request({
            url: process.env.APP_URL + "/api/get-user-details",
            headers: { 'Accept' : 'application/json', 'Authorization' : token },
            type: "GET",
            async:  "true",
            },
            function(error, response, body) {
                try {
                    let token1 = JSON.parse(response.body);
                   // console.log("token1token1",token1)
                    resolve(token1);
                }
                catch(err) {
                  // console.log('djfnsjkdfnjkdnf');
                   reject({ "err": "unauthorized" })
                }
            }
        );
    });
}



//var redisClient = Redis.createClient({sentinels:[{ host: process.env.REDIS_HOST, port: process.env.REDIS_PORT}] password: process.env.REDIS_PASSWORD, sentinels : null});


                               /*********** App Chat Message Subscribe End ***********/


                               /*********** All Sockets ***********/
io.on('connection', async(socket) => {
   console.log('connected to sockets',socket.id)
   
   
    let new_client = new_redis.createClient();
      console.log('socket',socket)
      let token = socket.handshake.query.token;
       console.log(token);
      let data1 = await checkVerifyToken(token);
     
      let findUser = data1.user;
     
      await new_client.set(findUser.id,socket.id);

      await socket.emit('socketConnected', {
          status: 200,
          message: 'ADDED_TO_SOCKET',
          data: {socketId: socket.id}
      });
	  
	 
	  console.log('Done');
	  con.query("update `users` set socket_id='"+socket.id+"' where id='"+findUser.id+"'", function(err, res){
                global.is_read = 0;
				if(err)
                       {
                           console.log(err.message);

                       }
				
            });
   
   
   
   
   
   
   
   
   
   
   

   /*********** Add User Event ***********/
   socket.on('add-user', function(data, callback)
   {
       if(!data.sender_id){
           //console.log('User Id is Required');

       }
       // else if(!data.api_token){
       //     console.log('User Api Token is Required');

       // }
       else
       {
//            console.log("Id:"+ data.user_id+"--Token:"+data.api_token);
           // var token = data.api_token.toString().split(" ");
           // if(token.length >= 2)
           //     token = token[1];
           // else
           //     token = token[0];

           con.query("SELECT * FROM users WHERE id_din="+data.sender_id, function(error, results, fields){
               if(error)
               {
                  // console.log(error.message);
               }
               else if(results == undefined || results.length == 0)
               {
//                    console.log(token+"- Invalid API Token! -"+data.user_id);
               }
               else
               {

                   /*********** Update User ***********/
                   con.query("UPDATE user_info SET socket_id='"+data.socket_id+"' WHERE id="+results[0].id+" ", function(ierror, iresults, ifields){
                       if(ierror)
                       {
                           //console.log(ierror.message);

                       }
                       else
                       {
                           con.query("select x.user_id as sender_id, ui.name as sender_name, cm.* from(select * from conversation_users where conversation_id in("+
                                   "SELECT c.id FROM conversations c "+
                                   "INNER JOIN conversation_users cu on cu.conversation_id = c.id "+
                                   "where cu.user_id = "+results[0].id+" )) as x "+
                                   "INNER JOIN conversation_users cu on cu.user_id = x.user_id "+
                                   "INNER JOIN conversation_messages cm on cm.conversation_id = x.conversation_id and cm.conversation_user_id = cu.id "+
                                   "LEFT JOIN user_info ui on ui.id  = x.user_id "+
                                   "where x.user_id <> "+results[0].id+" and cm.is_read = 2", function(err, res){
                                   if(err)
                                   {
                                       //console.log(err.message);
                                   }
                                   else
                                   {
                                       if(res.length > 0)
                                       {
                                           io.sockets.to(data.socket_id).emit('unDeliveredMessages', res);
                                       }
                                   }
                           });
                           //console.log("Socket ID Connected Successfully");
                       }
                   });
               }
               /*********** Update User End ***********/
           });
       }
   });
   /*********** Add User Event End ***********/


   /*********** Mark Mesaages as Read Event ***********/
   socket.on('mark-read', function(data, callback)
   {
       if(!data.receiver_id){
           //console.log('Sender User Id is Required');
       }
       // else if(!data.api_token){
       //     console.log('User Api Token is Required');
       // }
       else
       {
           // var token = data.api_token.toString().split(" ");
           // if(token.length >= 2)
           //     token = token[1];
           // else
           //     token = token[0];
//console.log(data.user_id+"--"+data.other_user_id);
           con.query("SELECT * FROM users WHERE id_din="+data.sender_id, function(error, results, fields){
               if(error)
               {
                   //console.log(error.message);
               }
               else if(results == undefined || results.length == 0)
               {
 //                  console.log(token+" Invalid API Token! "+data.user_id);
               }
               else
               {
//console.log("UPDATE conversation_messages SET is_read=true WHERE conversation_id="+data.conversation_id+" and conversation_user_id in(select id from conversation_users where user_id="+data.other_user_id+" and conversation_id="+data.conversation_id+")");
                   /*********** Update User ***********/
                   con.query("UPDATE conversation_messages SET is_read=true WHERE conversation_id="+data.conversation_id+" and conversation_user_id in(select id from conversation_users where user_id="+data.receiver_id+" and conversation_id="+data.conversation_id+")", function(uerror, uresults, ifields){
                       if(uerror)
                       {
                           //console.log(uerror.message);
                       }
                       else
                       {
                           //console.log("Marked as read");
                       }
                   });
               }
               /*********** Update User End ***********/
           });
       }
   });
   /*********** Add User Event End ***********/

   /*********** Get Message Deliver Status ***********/
   socket.on('setDelivered', function(data, callback)
   {
       if(!data.sender_id){
           //console.log('User Id is Required');
       }
       // else if(!data.api_token){
       //     console.log('User Api Token is Required');
       // }
       else
       {
           // var token = data.api_token.toString().split(" ");
           // if(token.length >= 2)
           //     token = token[1];
           // else
           //     token = token[0];
           con.query("SELECT * FROM users WHERE id_din='"+data.sender_id, function(error, results, fields){
               if(error)
               {
                   //console.log(error.message);
               }
               else if(results == undefined || results.length == 0)
               {
                   //console.log("Invalid API Token!");
               }
               else
               {
                   con.query("update conversation_messages set is_read = 0 "+
                           "where conversation_user_id in("+
                           "SELECT id from conversation_users where conversation_id in("+
                           "SELECT c.id FROM `conversations` c "+
                           "INNER JOIN conversation_users cu on cu.conversation_id = c.id "+
                           "WHERE cu.user_id = "+results[0].id+") and user_id != "+results[0].id+")", function(upderror, updresult){
                           if(upderror)
                           {
                               callback(upderror.message);
                           }
                           else
                           {
                               callback("success");
                           }
                   });
               }
           });
       }
   });
   /*********** Get Message Deliver End ***********/


   /*********** Remove Socket On Disconnect ***********/
   socket.on('disconnect', function()
   {
       con.query("UPDATE users SET socket_id='' WHERE socket_id='"+socket.id+"' ", function(ierror, iresults, ifields){
           if(ierror)
           {
               //console.log(ierror.message);
           }
           else
           {
               //console.log("Socket Disconnected Successfully");
           }
       });
   });
   /*********** Remove Socket On Disconnect End ***********/
});
                                   /*********** All Sockets  End***********/
