<?php
	session_start();
        require_once('../path.inc');
        require_once('../get_host_info.inc');
        require_once('../rabbitMQLib.inc');
	
	if (isset($_SESSION['username'])){

		$client = new rabbitMQClient("RabbitMQ.ini","BackendServer");

		$request = array();
		$request['type'] = "placebet";
		$request['email'] = $_SESSION["username"];
		$request['id'] = $_REQUEST["id"];
		$request['team'] = $_REQUEST['team'];
		$request['amount'] = $_REQUEST['amount'];
		$response = $client->send_request($request);

		echo $response;
	}
	else {
		echo 3; // not logged in
	}
?>

