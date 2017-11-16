<?php
	session_start();


	if (isset($username))
	{
		$loggedIn = True;
		$username = $_SESSION["username"];
	}
	else
	{
		$loggedIn = False;
		header("Location: index.php");
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
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
				<li class="active"><a href="games.php">Games</a></li>
			</ul>	
			<ul class="nav navbar-nav navbar-right">
				 
					<?php					
					if (isset($_SESSION['username']))
					{
						echo '<li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>' . $_SESSION['username'] . '</a></li>	
							<li><a href="./scripts/logout.php"><span class="glyphicon glyphicon-log-out"></span>Logout</a> </li>';
					}
					else
					{
						echo '<li><a href="login.php">Login</a> </li>';
					}
				?>				
			</ul>
		</div>
		</nav>
		<?php
			require_once('path.inc');
        		require_once('get_host_info.inc');
        		require_once('rabbitMQLib.inc');

        		$client = new rabbitMQClient("RabbitMQ.ini","BackendServer");

		        $request = array();
        		$request['type'] = "games";
			$request['numOfGame'] = 3;
		        $response = $client->send_request($request);
			$games = json_decode($response, true);

			$nba = '<div class="col-sm-4">
				<table class="table table-hover">              
                         	<thead><tr><th colspan="3"><h1>Basketball</h1></th></tr></thead>
                         	<tbody>
					<tr><td>Upcoming Games</td><td>Date Time</td></tr>';
			if (empty($games['nba'][0])) {
                                $nba .= '<tr><td colspan="2">There are no scheduled games in the next week.</td></tr>';
                        }
                        else {                                
				for ($i = 0; $i < count($games['nba']); $i++){
					$nba .= '<tr><td>' . $games['nba'][$i]['team1'] . ' vs ' .  $games['nba'][$i]['team2'] . '</td><td>' . 
					date("Y-m-d h:i:sa", strtotime($games['nba'][$i]['start'])) . '</td><td><button type="button" class="btn-primary">Place Bet</button></td></tr>';
				}
			}
			$nba .= '</tbody></table></div>';

			echo $nba;

			$nfl = '<div class="col-sm-4">
                                <table class="table">              
                                <thead><tr><th colspan="2"><h1>Football</h1></th></tr></thead>
                                <tbody>
                                        <tr><td>Upcoming Games</td><td>Date Time</td></tr>';
			if (empty($games['nfl'][0])) {
				$nfl .= '<tr><td colspan="2">There are no scheduled games in the next week.</td></tr>';
			}
                        else {
				for ($i = 0; $i < count($games['nfl']); $i++){
                                	$nfl .= '<tr><td>' . $games['nfl'][$i]['team1'] . ' vs ' .  $games['nfl'][$i]['team2'] . '</td><td>' .
                                        	date("Y-m-d h:i:sa", strtotime($games['nfl'][$i]['start'])) . '</td><td><button type="button" class="btn-primary">Place Bet</button></td></tr>';
                        	}
			}
                        $nfl .= '</tbody></table></div>';

                        echo $nfl;
		

			$mlb = '<div class="col-sm-4">
                        	 <table class="table">              
                                 <thead><tr><th colspan="2"><h1>Football</h1></th></tr></thead>
                                 <tbody>
                                         <tr><td>Upcoming Games</td><td>Date Time</td></tr>';
                        if (empty($games['nfl'][0])) {
                                  $mlb .= '<tr><td colspan="2">There are no scheduled games in the next week.</td></tr>';
                        }
                        else {
                                for ($i = 0; $i < count($games['mlb']); $i++){
                        		$mlb .= '<tr><td>' . $games['mlb'][$i]['team1'] . ' vs ' .  $games['mlb'][$i]['team2'] . '</td><td>' .
                                               date("Y-m-d h:i:sa", strtotime($games['mlb'][$i]['start'])) . '</td><td><button type="button" class="btn-primary">Place Bet</button></td></tr>';
                                 }
                         }
                         $mlb .= '</tbody></table></div>';
 
                         echo $mlb;
			?>

	</body>
</html>
