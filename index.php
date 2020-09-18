<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="styles.css">
	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
</head>
<body>


	<div id="wrapper">

	<h1> Welcome <?php session_start(); $_SESSION['username'];?> to Shahd's Chat Room!</h1>
	<div class="chat_wrapper">
		<div id="chat">
			
		</div>

		<form method="POST" id="messageForm">
			<textarea name="message" cols="30" rows="7" class="textarea"></textarea>
		</form>
	</div>
</div>
<script>
	LoadChat();

	setInterval(function(){
		LoadChat();

	}, 1000);

	function LoadChat(){
		$.post('handlers/messages.php?action=getMessage', function(response){

			var scrollpos = $('#chat').scrollTop();
			var scrollpos = parseInt(scrollpos)+520;//chat div is 520 (500 + 10 top padding + 10 bottom padding)
			var scrollHeight = $('#chat').prop('scrollHeight');

			$('#chat').html(response);

			if(scrollpos<scrollHeight){

			}
			else
			//should NOT run when the user is trying to scroll up
			$('#chat').scrollTop($('#chat').prop('scrollHeight'));

		});
	}


	$('.textarea').keyup(function(e){//focusing on text area and pressing any key
		//alert($(this).val());

		//alert(e.which); ascii codes

		if(e.which == 13){//enter = 13 ascii code
			$('form').submit();
		}
	});

//REVISE: CLEARING THE FORM UNSUCCESSFUL?? 
//uodate: used jquery instead of document.getElementById, works
	$('form').submit(function(){
		var message = $('.textarea').val();
		$.post('handlers/messages.php?action=sendMessage&message='+message,function(response){
			if(response==1){
				LoadChat();
				$("#messageForm")[0].reset();
			}
		});
		return false;//doesnt refresh webpage but text still on textarea
	});
</script>
</body>
</html>