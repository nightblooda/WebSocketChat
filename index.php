<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>WebSocketChat</title>
<style>
	body {width:960px;margin:auto}
	#conversation {height:500px;border:1px solid #000}
	input {width:100%}
</style>
<script src='assets/javascript/ServerEventDispatcher.js'></script>
<script>
	//Connect to the server
	var server = new ServerEventsDispatcher("127.0.0.1:12345");

	//Let the user know we're connected
	server.bind('open', function() {
		log( "Connected" );
	});

	//OH NOES! Disconnection occurred.
	server.bind('close', function( data ) {
		log( "Disconnected" );
	});

	//Log any messages sent from server
	server.bind('message', function( payload ) {
		log( payload.data );
	});

	//Log a message to the conversation window
	function log( msg ) {
		document.getElementById('conversation').innerHTML += msg + '<br>';
	}

	//Does the actual sending of a message
	function send( msg ) {
		server.trigger( 'message', { data: msg } );
	}

	//Sends a message when user presses the 'enter' key
	function onkey( event ) {
		if ( event.keyCode == 13 )
		{
			var message = document.getElementById('message').value;
			log( '> ' + message );
			send( message );
		}
	};
</script>
</head>
<body>
	<div id='conversation'>&nbsp;</div>
	<input type='text' id='message' onkeypress="onkey(event)">
</body>
</html>