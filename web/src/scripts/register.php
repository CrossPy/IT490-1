<?php
	try{
		require_once('../path.inc');
		require_once('../get_host_info.inc');
		require_once('../rabbitMQLib.inc');
		
		$client = new rabbitMQClient("RabbitMQ.ini","BackendServer");

		$request = array();
		$request['type'] = "register";
		//$request['type'] = "insert_game_data";
		$request['password'] = $_POST["password"];
		$request['email'] = $_POST["email"];
		$request['firstName'] = $_POST["firstName"];
		$request['lastName'] = $_POST["lastName"];
			
		$response = $client->send_request($request);		

	}catch(Exception $e){
		echo $e->getMessage();
	}
?>

<html>
	<head>
		<title>NJIT Bookies | Register Failed</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<ul>
			<li style="color:green; border-right: 1px solid #bbb"><a href="index.php"><b>NJIT Bookies</b></a></li>
			<li><a href="register.html">Register</a></li>
			<li style="float:right" class="dropdown" >
				<a href="#" class="dropbtn">
			    	<div class="dropdown-content">
			      	<a href="login.html">Login</a>
			    	</div>
			</li>
		</ul>
		<br>
		<br>		
		<div>
	
			<h1>Register</h1>

			<?php
				if ($response != "1")
				{
					session_start();
					echo $response;
					$_SESSION["username"] = $response;
				header("Location: ../profile.php");
				}

				if ($response == "1")
				{
					echo "<center><b><font color='red'>Account could not be created. That email address is already in use.</center></b><br><br>";
					echo "<center><a href=register.html>Go Back</center></a>";
				}

			?>
		</div>
	</body>
</html>
