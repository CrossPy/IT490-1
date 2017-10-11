#!/usr/bin/php
<?php
	require_once('path.inc');
	require_once('get_host_info.inc');
	require_once('rabbitMQLib.inc');
	$configs = include('server_config.php');

	function requestProcessor($request)
	{
		global $response;

		if(!isset($request['type'])){return "ERROR: unsupported message type";}

		switch ($request['type'])
		{
			case "login":
				return doLogin($request['email'],$request['password']);

			case "validate_session":
				return doValidate($request['sessionId']);

			case "register":
				return doRegister($request['username'],$request['password'],$request['email'], $request['firstName'], $request['lastName'], $request['Address'], $request['SATScore'], $request['major']);

			case "logout":
				return doLogout($request['username'],$request['password'],$request['sessionId']);

			case "profile":
				return getProfile($request['username']);
		}
	}

	function doLogin($email,$password)
	{
		$con=mysqli_connect ($configs['SQL_Server'],$configs['SQL_User'],$configs['SQL_Pass'],$configs['SQL_db']);
		$login = fopen("login.txt", "a") ;
		$date = date("Y-m-d");
		$time = date("h:i:sa");

		$sql="select * from users where email = '$email'";

		$result=mysqli_query($con,$sql);
		$count=mysqli_num_rows($result);

		if ($count < 1)
		{
			//username does not exist
			$response = "2";
			$string = "$date $time Response Code 2: Email $email does not exist.\n";

			fwrite($login, $string);
			return $response;
		}
		else
		{

			$sql="select * from users where email = '$email' AND password = sha1('$password')";

			$result=mysqli_query($con,$sql);
			$count=mysqli_num_rows($result);

			if ($count == 1)
			{
				//login successful
				$response = "0";
				$string = "$date $time Response Code 0: Login successful for email  $email.\n";

				fwrite($login, $string);
				return $response;

			}

			elseif ($count == 0)
			{
				//wrong password
				$response = "1";
				$string = "$date $time Response Code 1: Wrong password for email $email.\n";

				fwrite($login, $string);
				return $response;
			}
		}
	}

	function doRegister($email, $password, $firstName, $lastName)
	{
		$register = fopen("register.txt", "a") ;
		$date = date("Y-m-d");
		$time = date("h:i:sa");

		$con = mysqli_connect($configs['SQL_Server'],$configs['SQL_User'],$configs['SQL_Pass'],$configs['SQL_db']);

		$sql="select * from users where email='$email'";

		$result=mysqli_query($con,$sql);
		$count=mysqli_num_rows($result);


		if ($count >= 1)
		{
				//email already registered
				$response = "1";
				$log = "$date $time Response Code 1: Email $email already registered.\n";

				fwrite($register, $log);
				return $response;	
		}else{

			$sql="INSERT INTO users (email, password, firstName, lastName) VALUES('$email', sha1('$password'), '$firstName', '$lastName')";
			if (mysqli_query ($con,$sql))
			{
				//inserted into database
				$response = "0";
				$log = "$date $time Response Code 0: Email $email successfully added to database.\n";

				fwrite($register, $log);
				return $response;
			}
		}
	}

	function getProfile($username)
	{	
		$con=mysqli_connect ($configs['SQL_Server'],$configs['SQL_User'],$configs['SQL_Pass'],$configs['SQL_db']);
		$sql="select * from users where email = '$email'";

		$result=mysqli_query ($con,$sql);
		$count=mysqli_num_rows ($result);

		while ($row=mysqli_fetch_array($result))
		{
			$email = $row['email'];
			$firstName = $row['firstName'];
			$lastName = $row['lastName'];		
		}

		$response = array($email, $firstName, $lastName);
		return $response;
	}

	$server = new rabbitMQServer("RabbitMQ.ini","BackendServer");

	$server->process_requests('requestProcessor');
	exit();
?>
