<!DOCTYPE html>
<?php
	session_start();
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
<html>
 	<head>
		<title>NJIT Bookies | Register</title>
		<!--<link rel="stylesheet" type="text/css" href="style.css">-->
		<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous"/>-->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
	</head>

<body>
		<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
			  <a class="navbar-brand" href="index.php">NJIT Bookies</a>
			</div>
			<ul class="nav navbar-nav">
			  <li><a href="index.php">Home</a></li>
			  <li><a href="register.php">Register</a></li>
			</ul>	
			<ul class="nav navbar-nav navbar-right">
				<li><li class="active"><a href="profile.php"><span class="glyphicon glyphicon-user"></span> <?php if (isset($email)) {echo "<b>$email</b>";} else {echo "<b>Anonymous</b>";}?></a></li>
				<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			</ul>
		</div>
	</nav>
	


<body> 







<html>

	<body>
<?php 
	echo "<h1> $response[1] $response[2] </h1>";		
?>


	</body>

</html>
