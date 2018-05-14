<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Realtime Message</title>

  </head>
  <style>
  body { padding-top: 70px; }
  
  #load { height: 100%; width: 100%; }
  #load {
    position    : fixed;
    z-index     : 99999; /* or higher if necessary */
    top         : 0;
    left        : 0;
    overflow    : hidden;
    text-indent : 100%;
    font-size   : 0;
    opacity     : 0.6;
  }
  
  .RbtnMargin { margin-left: 5px; }
  
  
  </style>
  <body>


                <button type="button" id="submit" class="btn btn-primary">Submit</button>


<script src="https://code.jquery.com/jquery-1.11.1.js"></script>

	<script src="http://192.168.1.101/dibantu/node_modules/socket.io/node_modules/socket.io-client/socket.io.js"></script>
	<script>
  $(document).ready(function(){

		$("#load").hide();

    $("#submit").click(function(){
      

                var socket = io.connect( 'http://192.168.1.101:3000' );

                socket.emit('new job', { 

                });




            });

          }); 

	</script>
  </body>
</html>