
const server = require('http').createServer();
const options = { 
 cors:true,
 origins:["http://127.0.0.1:3000"],
};
const io = require('socket.io')(server, options);
io.on('connection', function(socket){

	console.log('connected');

	socket.on('sendchatToServer', function(message){
	 console.log(message);
	 io.sockets.emit('serverchatToClient',message);
	});


	socket.on('disconnect', function(scoket){

	 console.log('leaved');

	});

});

server.listen(3000);

