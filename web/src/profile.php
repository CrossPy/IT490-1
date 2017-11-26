<?php
	session_start();

	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	ini_set('display_errors' , 1);

	if(!isset($_SESSION['username'])) {
		header("Location: index.php");
	}
	$email = $_SESSION["username"];
	require_once('path.inc');
	require_once('get_host_info.inc');
	require_once('rabbitMQLib.inc');

	$client = new rabbitMQClient("RabbitMQ.ini","BackendServer");

	$request = array();
	$request['type'] = "profile";
	$request['email'] = $email;
	$response = $client->send_request($request);
?>
<!DOCTYPE html>
<html>
<head>
	<title>NJIT Bookies | Profile</title>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>	
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
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
			<li><a href="index.php">Home</a></li>
			<li><a href="games.php">Games</a></li>
		</ul>	
		<ul class="nav navbar-nav navbar-right">
			<li class="active"><a href="profile.php"><span class="glyphicon glyphicon-user"></span>
			<?php echo $email;?></a></li>
			<li><a href="./scripts/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
		</ul>
	</div>
	</nav>
	<div class="container">
		<?php 
			echo "<h1>Hello " . $response['firstName'] . " " . $response['lastName'] . "</h1><br/>
					Current balance is $" . $response['balance'];			
		?>
		<div class="panel panel-default bk" >
			<div class="panel-heading"><h4>Transaction History</h4></div>
			<div class="panel-body">
			<?php
				$transHistory = '
							<div class="col-sm-12"><table class="table">
							<thead><tr>
							<th>Sport</th>
							<th>Game</th>
							<th>Game Date</th>
							<th>Pick</th>
							<th>Amount</th>
							<th>Transaction Date</th>
							</tr></thead><tbody>';
				for ($i = 0; $i < count($response['history']); $i++) {
					$transHistory .= '<tr><td>' . strtoupper($response['history'][$i]['sport']) . '</td><td>' . $response['history'][$i]['team1'] 
					. ' vs ' .  $response['history'][$i]['team2'] . '</td><td>' . $response['history'][$i]['start'] . '</td><td>' 
					. $response['history'][$i]['team'] . '</td><td>' . $response['history'][$i]['amount'] . '</td><td>'
					. $response['history'][$i]['timestamp'] . '</td></tr>';
				}
				$transHistory .= "</tbody></table></div><fieldset>";
				echo $transHistory;
			?>
			</div>
		</div>
	</div>
</body>

</html>
