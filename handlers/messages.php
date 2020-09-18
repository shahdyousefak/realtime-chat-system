<?php
//note: -> in php is like . in java/js.
//The object operator, ->, is used in object scope to access methods and properties of an object. It’s meaning is to say that what is on the right of the operator is a member of the object instantiated into the variable on the left side of the operator. 
include('../config.php');
switch($_REQUEST['action']){//inside action variable

	case "sendMessage":
	//global $db;
	session_start();
	$query = $db->prepare("INSERT INTO messages SET user=?, message=?");
	//pass a value for message to store into db
	$run = $query->execute([$_SESSION['username'],$_REQUEST['message']]);//stored in table
	if($run){
		echo 1;
		exit;
	}
	break;

	case "getMessage":

	$query = $db->prepare("SELECT * FROM messages");
	$run = $query->execute();

	$rs = $query->fetchAll(PDO::FETCH_OBJ);
	$chat = '';
	foreach($rs as $message){
		//$chat .= $message->message.'<br/>'; //carry a single message column name 
		$chat .= '<div class="single-message">
		<strong>'.$message->user.': </strong> '.$message->message.'<span>'.date('m-d-Y h:i a', strtotime($message->date)).'</span>
		</div>';

	}
	echo $chat;
	break;

}

?>