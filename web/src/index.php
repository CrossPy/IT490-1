<?php
	session_start();
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	ini_set('display_errors' , 1);


	if (isset($username))
	{
		$loggedIn = True;
		$username = $_SESSION["username"];
	}
	else
	{
		$loggedIn = False;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">		
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>NJIT Bookies | Home</title>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>	
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="bookies.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>
	<link rel="stylesheet" href="style.css"/>
</head>

<body>
<nav class="navbar navbar-inverse">
	<div class="container">
		<div class="navbar-header">
		  <a class="navbar-brand" href="index.php">NJIT Bookies</a>
		</div>
		<ul class="nav navbar-nav">
		  <li class="active"><a href="index.php">Home</a></li>
		  <li><a href="games.php">Games</a></li>
		</ul>	
		<ul class="nav navbar-nav navbar-right">
			 
				<?php					
				if (isset($_SESSION['username']))
				{
					echo '<li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> ' . $_SESSION['username'] . '</a></li>	
						<li><a href="./scripts/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a> </li>';
				}
				else
				{
					echo '<li> <a href="register.php">Register</a></li>
						<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';

				}
			?>				
		</ul>
	</div>		
</nav>
<div class="container">	
	<div class="panel panel-default bk">
		<div class="panel-heading">Upcoming Games</div>
		<div class="panel-body">
			<?php
				require_once('path.inc');
				require_once('get_host_info.inc');
				require_once('rabbitMQLib.inc');
				$client = new rabbitMQClient("RabbitMQ.ini","BackendServer");

				$request = array();
				$request['type'] = "games";
				$response = $client->send_request($request);
				$games = json_decode($response, true);

				require_once('scripts/functions.php');
				
				$nba = getPrepareGameSchedule($games['nba'], 5);
				if (!empty($games['nba'][0])) {
				echo '<div class="panel panel-default bk">            
						<div class="panel-heading">NBA - Basketball</div>					
						<table class="table">  
						<tbody>
						<tr><td>Upcoming Games</td><td>Date Time</td></tr>'
						. $nba[0] . '</tbody></table><a href="games.php?sport=nba"><button type="button" class="btn btn-link btn-block">View more</button></a></div>';
				}

				$nfl = getPrepareGameSchedule($games['nfl'], 5);
				if (!empty($games['nfl'][0])) {
					echo '<div class="panel panel-default bk">   
						<div class="panel-heading">NFL - Football</div>
						<table class="table">
						<tbody>
						<tr><td>Upcoming Games</td><td>Date Time</td></tr>'
						. $nfl[0] . '</tbody></table><a href="games.php?sport=nfl"><button type="button" class="btn btn-link btn-block">View more</button></a></div>';
				}

				$mlb = getPrepareGameSchedule($games['mlb'], 5);
				if (!empty($games['mlb'][0])) {
					echo '<div class="panel panel-default bk">
						<div class="panel-heading">MLB - Baseball</div>
						<table class="table">  
						<tbody>
						<tr><td>Upcoming Games</td><td>Date Time</td></tr>'
						. $mlb[0] . '</tbody></table><a href="games.php?sport=mlb"><button type="button" class="btn btn-link btn-block">View more</button></a></div>';
				}			
				
				/*
				if ($nba[1] != null) {
					echo $nba[1];
				}
				if ($nfl[1] != null) {
					echo $nfl[1];
				}
				if ($mlb[1] != null) {
					echo $mlb[1];
				}
				*/
			?>
		</div>
	</div>
</div>
<div id="response" class="modal fade" role="dialog">
	<div class="modal-dialog">		
		<div id="responseBody" class="modal-body"></div>
	</div>
</div>
</body>
</html>
