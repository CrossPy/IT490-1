!/usr/bin/php
<?php
	require_once('path.inc');
	require_once('get_host_info.inc');
	require_once('rabbitMQLib.inc');
	$configs = include('server_config.php');
	print_r($configs);
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
				print_r($request);
				return doRegister($request['email'],$request['password'],$request['firstName'],$request['lastName']);

			case "logout":
				return doLogout($request['username'],$request['password'],$request['sessionId']);

			case "profile":
				return getProfile($request['email']);
			case "insert_game_data":
				print_r($request);
				return insert_game_data($request);// waiting for data type.
		}
	}

	function doLogin($email,$password)
	{
global $configs;
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

			$sqlLog = "insert into event_log values (NOW(), 'Response Code 2: Email $email does not exist.')";
                        $loggin = $result=mysqli_query($con, $sqlLog);

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
				
				$sqlLog = "insert into event_log values (NOW(), 'Response Code 0: Login successful for email $email.')";
                        	$loggin = $result=mysqli_query($con, $sqlLog);

				fwrite($login, $string);
				return $response;

			}

			elseif ($count == 0)
			{
				//wrong password
				$response = "1";
				$string = "$date $time Response Code 1: Wrong password for email $email.\n";

				$sqlLog = "insert into event_log values (NOW(), 'Response Code 1: Wrong password for email $email.')";
                                $loggin = $result=mysqli_query($con, $sqlLog);


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
		global $configs;
		$con = mysqli_connect($configs['SQL_Server'],$configs['SQL_User'],$configs['SQL_Pass'],$configs['SQL_db']);

		$sql="select * from users where email='$email'";

		$result=mysqli_query($con,$sql);
		$count=mysqli_num_rows($result);


		if ($count >= 1)
		{
				//email already registered
				$response = "1";
				$log = "$date $time Response Code 1: Email $email already registered.\n";

				$sqlLog = "insert into event_log values (NOW(), 'Response Code 1: Email $email already registered.')";
				$loggin = $result=mysqli_query($con, $sqlLog);

				fwrite($register, $log);
				return $response;	
		}else{

			$sql="INSERT INTO users (email, password, firstName, lastName, balance) VALUES('$email', sha1('$password'), '$firstName', '$lastName', 100)";
			if (mysqli_query ($con,$sql))
			{
				//echo mysqli_error($con);
				//inserted into database
				$response = "0";
				$log = "$date $time Response Code 0: Email $email successfully added to database.\n";

				$sqlLog = "insert into event_log values (NOW(), 'Response Code 0: Email $email successfully added to database.')";
                                $loggin = $result=mysqli_query($con, $sqlLog);
				
				fwrite($register, $log);
				return $response;
			}
		}
	}

	function getProfile($email)
	{	
		$con=mysqli_connect($configs['SQL_Server'],$configs['SQL_User'],$configs['SQL_Pass'],$configs['SQL_db']);
		$sql="select * from users where email = '$email'";
		$result=mysqli_query ($con,$sql);
		$count=mysqli_num_rows ($result);
		echo $email;		

		while ($row=mysqli_fetch_array($result))
		{
			$email = $row['email'];
			$firstName = $row['firstName'];
			$lastName = $row['lastName'];		
			$balance = $row['balance'];
		}

		$response = array($email, $firstName, $lastName, $balance);
		return $response;
	}
	
	function insert_game_data($result) {
		global $configs;
		$con = mysqli_connect($configs['SQL_Server'],$configs['SQL_User'],$configs['SQL_Pass'],$configs['SQL_db']);

		$sql="select id from games where id='" . $result["identifier"] ."'";

		$query = mysqli_query($con,$sql);
		$count = mysqli_num_rows($query);
		
		if ($count < 1) {
			$date = date("Y-m-d H:i:s", strtotime($result['time'] . " " . $result['date']));
			$sql = "INSERT INTO games (id, sport, team1, team2, start) 
				VALUES(" .$result['identifier'] . ", '" . $result['sport'] . "', '" . $result['homeTeam'] . "', '" . $result['awayTeam'] . "', '$date')";
			$insert = mysqli_query($con, $sql);
			echo mysqli_error($con);
			
			$sqlLog = "insert into event_log values (NOW(), 'Game ID " . $result['identifier'] . " inserted into database')";
                        $loggin = $result=mysqli_query($con, $sqlLog);
			echo mysqli_error($con);

		}
	}
	
	$server = new rabbitMQServer("RabbitMQ.ini","BackendServer");

	$server->process_requests('requestProcessor');
	exit();
?>
