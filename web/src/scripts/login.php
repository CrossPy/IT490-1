<?php
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
		<title>NJIT Bookies | Login Failed</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<ul>
			<li style="color:green; border-right: 1px solid #bbb"><a href="../index.php"><b>NJIT Bookies</b></a></li>
			<li><a href="../register.php">Register</a></li>
			<li style="float:right" class="dropdown" >
			    <a href="#" class="dropbtn">Logged in as: <?php if (isset($username)) {echo "<b>$username<b>";} else {echo "<b>Anonymous<b>";}?></a>
			    <div class="dropdown-content">
			      <a href="../login.php">Login</a>
			    </div>
			  </li>
		</ul>

		<br><br>
		
		<div>

			<h1>Login</h1>
		
			<?php

				if ($response == "0")
				{
					session_start();
					$_SESSION["username"] = $username;
					header("Location: ../profile.php");
				}

				if ($response == "1")
				{
					echo '<p style="text: center;">Login could not be authenticated</p>';
					header('Refresh: 3; url= ../login.php');
				}
			?>
		</div>
	</body>
</html>
