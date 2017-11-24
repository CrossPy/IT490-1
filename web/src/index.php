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
	<title>NJIT Bookies | Home</title>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>-->
		
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="style.css"/>
	
	<script>
		$(document).ready(function(){		
			$("button").click(function(){				
				var id  = $(this).attr("id");
				$('#div_' + id).css("display","block");
			});			
		});
		function cancelBet(id){
			document.getElementById("div_" + id).style.display = "none";
		}
	</script>
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
			
			$nba = getPrepareGameScedule($games['nba'], 5);
			echo '<div class="col-sm-4">
					<table class="table">              
                   	<thead><tr><th colspan="3"><h1>Basketball</h1></th></tr></thead>
                   	<tbody>
					<tr><td>Upcoming Games</td><td>Date Time</td></tr>'
					. $nba[0] . '</tbody></table></div>';

			$nfl = getPrepareGameScedule($games['nfl'], 5);
			echo '<div class="col-sm-4">
					<table class="table">              
					<thead><tr><th colspan="3"><h1>Football</h1></th></tr></thead>
					<tbody>
					<tr><td>Upcoming Games</td><td>Date Time</td></tr>'
					. $nfl[0] . '</tbody></table></div>';

			$mlb = getPrepareGameScedule($games['mlb'], 5);
			echo '<div class="col-sm-4">
					<table class="table">              
					<thead><tr><th colspan="3"><h1>Baseball</h1></th></tr></thead>
					<tbody>
					<tr><td>Upcoming Games</td><td>Date Time</td></tr>'
					. $mlb[0] . '</tbody></table></div>';
			
			if ($nba[1] != null) {
				echo $nba[1];
			}
			if ($nfl[1] != null) {
				echo $nfl[1];
			}
			if ($mlb[1] != null) {
				echo $mlb[1];
			}
		?>
	</div>
	</body>
</html>
