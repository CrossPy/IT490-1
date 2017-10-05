<?php
ob_start();
session_start();

error_reporting(E_ALL);
ini_set("display_errors", 1);
   
function getdata($name, &$result){
	
	if (!isset($_REQUEST[$name])){
		return;
	}
	if (empty($_REQUEST[$name])){
		return;
	}
	
	$temp = $_REQUEST[$name];
	$result = $temp;
}

function auth($username, $password) {
	global $user_id;
	
	$s = "select user from users where email = '$username' and pass = '$password';";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~sms46/download/src/sql_query_mq.php");// needs to ge updated to location of sql_query_mq.php
	curl_setopt($ch, CURLOPT_POSTFIELDS, "query=$s");
	
	// receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$server_output = curl_exec ($ch);
	if(curl_errno($ch)){
    echo 'Curl error: ' . curl_error($ch);
	}
	
	curl_close ($ch);
	
	// further processing ....
	if ($server_output == true) {
		//$user_id = ;
		echo "$server_output";
	}
	else if ($server_output === false){
		echo "<br/>something";
	}
}

getdata("username", $username);
getdata("password", $password);

auth($username, $password);
	
/*if (isset($_POST['login']) && !empty($_POST['username']) 
   && !empty($_POST['password'])) {
	
   if ($_POST['username'] == ' ' && 
	  $_POST['password'] == ' ') {
	  $_SESSION['valid'] = true;
	  $_SESSION['timeout'] = time();
	  $_SESSION['username'] = 'tutorialspoint';
	  
	  echo 'You have entered valid use name and password';
	}
	else {
	  $msg = 'Wrong username or password';
   }
}*/
?>