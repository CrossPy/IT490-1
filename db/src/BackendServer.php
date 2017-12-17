!/usr/bin/php
<?php
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	ini_set('display_errors' , 1);
	require_once('path.inc');
	require_once('get_host_info.inc');
	require_once('rabbitMQLib.inc');
	$configs = include('server_config.php');
	print_r($configs);
	function requestProcessor($request){
		global $response;

		if(!isset($request['type'])){return "ERROR: unsupported message type";}

		switch ($request['type']){
			case "login":
				print_r($request);
				return doLogin($request['email'],$request['password']);

			case "validate_session":
				return doValidate($request['sessionId']);

			case "register":
				print_r($request);
				return doRegister($request['email'],$request['password'],$request['firstName'],$request['lastName']);

			case "logout":
				return doLogout($request['username'],$request['password'],$request['sessionId']);

			case "profile":
				print_r($request);
				return getProfile($request['email']);
			case "insert_game_data":
				print_r($request);
				return insert_game_data($request);
			case "games":
				print_r($request);
				return games($request);
			case "placebet";
				print_r($request);
				return bet($request);
		}
	}

	function doLogin($email, $password){
		global $configs;
		
		//Initialize the connection to the database.
		$con = mysqli_connect ($configs['SQL_Server'],$configs['SQL_User'],$configs['SQL_Pass'],$configs['SQL_db']);
		//Constructing the query to find user in the database.
		$sql = "select password from users where email = '$email'";
		$result = mysqli_query($con, $sql);
		$count = mysqli_num_rows($result);
		$array = mysqli_fetch_assoc($result);
		$pass = $array["password"];
		if ($count == 1){
			if (password_verify($password, $pass)){
				$response = "0";
				$sqlLog = "insert into event_log values (NOW(), 'Response Code 0: Email $email sucessfully logged in.')";
				$logging = $result=mysqli_query($con, $sqlLog);

				return $response;
			}
		}else{
			$response = "1";
			$sqlLog = "insert into event_log values (NOW(), 'Response Code 1: Email $email Failed login attempt')";
            $logging = $result=mysqli_query($con, $sqlLog);

			return $response;
		}

	}

	function doRegister($email, $password, $firstName, $lastName) {
		$register = fopen("register.txt", "a") ;
		$date = date("Y-m-d");
		$time = date("h:i:sa");
		global $configs;
		$con = mysqli_connect($configs['SQL_Server'],$configs['SQL_User'],$configs['SQL_Pass'],$configs['SQL_db']);
		$password = password_hash($password, PASSWORD_DEFAULT);
		$sql="select * from users where email='$email'";

		$result=mysqli_query($con,$sql);
		$count=mysqli_num_rows($result);


		if ($count >= 1){
			//email already registered
			$response = "1";
			$log = "$date $time Response Code 1: Email $email already registered.\n";

			$sqlLog = "insert into event_log values (NOW(), 'Response Code 1: Email $email already registered.')";
			$logging = $result=mysqli_query($con, $sqlLog);
			return $response;	
		}
		else{
			$sql="INSERT INTO users (email, password, firstName, lastName, balance) VALUES('$email', '$password', '$firstName', '$lastName', 100)";
			if (mysqli_query ($con,$sql)){
				$response = "$email";
				$log = "$date $time Response Code 0: Email $email successfully added to database.\n";

				$sqlLog = "insert into event_log values (NOW(), 'Response Code 0: Email $email successfully added to database.')";
				$loggin = $result=mysqli_query($con, $sqlLog);
				
				fwrite($register, $log);
				return $response;
			}
		}
	}

	function getProfile($email){
		global $configs;	

		$con = new mysqli($configs['SQL_Server'],$configs['SQL_User'],$configs['SQL_Pass'],$configs['SQL_db']);
		$user = "select * from users where email = '$email'";
		$trans = "select * from bets_table inner join games on bets_table.game = games.id where user='$email' order by timestamp DESC";
		$result = $con->query($user);
		$history = $con->query($trans) or die($con->error);
		printf($con->error);
		$row = $result->fetch_assoc();	
		$response = array('email' => $row['email'],'firstName' => $row['firstname'], 'lastName' => $row['lastname'], 'balance'=> $row['balance']);
		$response['history'] = array();
		
		while ($row = $history->fetch_assoc()){
			//print_r($row);
			array_push($response['history'], $row);
		}		
		return $response;
	}
	
	
	function insert_game_data($result) {
		global $configs;
		$id = $result["identifier"];
		$time = $result['time'];
		$date = $result['date'];
		$sport = $result['sport'];
		$homeTeam = $result['homeTeam'];
		$awayTeam = $result['awayTeam'];
		$homeScore = $result['homeScore'];
		$awayScore = $result['awayScore'];
		
		$con = new mysqli($configs['SQL_Server'],$configs['SQL_User'],$configs['SQL_Pass'],$configs['SQL_db']);

		$sql="select id, win from games where id='$id'";
		$query = $con->query($sql);
		$count = mysqli_num_rows($query);
		if ($count < 1) {
			$datetime = date("Y-m-d H:i:s", strtotime("$time $date"));
			$sql = "INSERT INTO games (id, sport, team1, team2, start) VALUES($id, '$sport', '$homeTeam', '$awayTeam', '$datetime')";
			$insert = $con->query($sql);
			if (!$insert->error) {
			   printf("Error message: %s\n", $con->error);
			}
			
			$sqlLog = "INSERT INTO event_log VALUES (NOW(), 'Game ID $id inserted into database')";
			$loggin = $con->query($sqlLog);
			if (!$loggin->error) {
			   printf("Error message: %s\n", $con->error);
			}
		}
		elseif(empty(mysqli_fetch_assoc($query)['win']) && $homeScore != $awayScore) {
			if ($homeScore > $awayScore) {
				$winner = $homeTeam;
			}
			else {
				$winner = $awayTeam;
			}
			$update = $con->query("UPDATE games SET score1 = $homeScore, score2 = $awayScore, win = '$winner' where id='$id'");
			if (!$update->error) {
			   printf("Error message: %s\n", $con->error);
			}
		}
		$con->close();
	}

	function games($result) {
		global $configs;

		$con = mysqli_connect($configs['SQL_Server'], $configs['SQL_User'], $configs['SQL_Pass'], $configs['SQL_db']);
		
		if (isset($result['sport'])){
			$sql = "select id, sport, team1, team2, start from games where start > NOW() and sport = '" . $result['sport'] . "'";
		}
		else {
			$sql = "select id, sport, team1, team2, start from games where start > NOW()";
		}

		$nba = array();
		$mlb = array();
		$nfl = array();

		$query = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			switch ($row['sport']) {
				case 'nba': {
					array_push($nba, array("id"=>$row['id'], "team1"=>$row['team1'], "team2"=>$row['team2'], "start"=>$row['start']));
					break;
				}
				case 'mlb': {
					array_push($mlb, array("id"=>$row['id'], "team1"=>$row['team1'], "team2"=>$row['team2'], "start"=>$row['start']));
					break;
				}
				case 'nfl': {
					array_push($nfl, array("id"=>$row['id'], "team1"=>$row['team1'], "team2"=>$row['team2'], "start"=>$row['start']));
					break;
				}
			}
		}		
		$return = array('nba'=>$nba, 'nfl'=>$nfl, 'mlb'=>$mlb);
		$response = json_encode($return);

		return $response;
	}

	 function bet($result) {
		global $configs;

		$con = new mysqli($configs['SQL_Server'], $configs['SQL_User'], $configs['SQL_Pass'], $configs['SQL_db']);

		$check = $con->query("select balance from users where email = '" . $result['email'] . "'");
		$row = $check->fetch_assoc();
		
		if($row['balance'] < $result['amount']) {
			return 2; // current balance is less then bet amount.
		}
		
		$teams = $con->query("select id, team1, team2 from games where id = '" . $result['id'] ."'") or die($con->mysqli_error);
		$game = $teams->fetch_assoc();
		
		if($game['team1'] == $result['team']) {
			$opposing = $game['team2'];
		}
		else {
			$opposing = $game['team1'];
		}
		
		$check = $con->query("select * from bets_table where game = '". $result['id'] . "' and user = '" . $result['email'] 
			. "' and team ='" . $opposing . "'");
		if ($check->num_rows >= 1) {
			return 0; //bet on opposing team exits	
		}
		else {
			$con->query("insert into bets_table (user, game, team, amount) values('" . $result['email'] . "','" . $result['id'] 
				. "','" . $result['team'] . "'," . $result['amount'] . ")");
			$con->query("update users set balance = balance - " . $result['amount'] . " where email = '" . $result['email'] . "'");

			$sqlLog = "insert into event_log values (NOW(), 'user " . $result['email'] . " placed " . $result['amount'] . " bet on " 
				. $result['team'] . " for game id " . $result['id'] . "')";
            $loggin = $con->query($sqlLog);

			printf($con->error);
			return 1; //succesfully made a bet and current balance updated
		}
		$con->close();		
	}
	

	$server = new rabbitMQServer("RabbitMQ.ini","BackendServer");

	$server->process_requests('requestProcessor');
	exit();
?>
