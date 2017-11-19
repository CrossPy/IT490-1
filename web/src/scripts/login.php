<?php 
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	ini_set('display_errors' , 1);

	require_once('../path.inc');
	require_once('../get_host_info.inc');
	require_once('../rabbitMQLib.inc');

	$client = new rabbitMQClient("RabbitMQ.ini","BackendServer");

	$request = array();
	$request['type'] = "login";
	$request['email'] = $_POST["email"];
	$request['password'] = $_POST["password"];
	$response = $client->send_request($request);

	$username = $request['email'];
?>

<html>
<head>
	<title>NJIT Bookies | Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../style.css">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
			
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>		
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
				<li><a href="register.php">Register</a></li>
				<li class="active"><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
			</ul>
		</div>
	</nav>
	<div class="container">
		<h1>Login</h1>		
		<?php
			if ($response == "0"){
				session_start();
				$_SESSION["username"] = $username;
				header("Location: ../profile.php");
			}
			 else {
				echo '<div class="alert alert-danger" style="text: center;">Login could not be authenticated.</div>';
				header('Refresh: 3; url= ../login.php');
			}
		?>
	</div>
	</body>
</html>
