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
	        $request['id'] = $_POST["id"];
		$request['team'] = $_POST['team'];
		$resquest['opposition'] = $_POST['']
		$request['amount'] = $_POST['amount'];
        	$response = $client->send_request($request);

	        return $response;
	}
	else {
		return 2;
	}
?>

