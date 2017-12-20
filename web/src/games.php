<?php
	session_start();
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	ini_set('display_errors' , 1);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">		
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>		
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="bookies.js"></script>
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
		  <li class="active"><a href="#">Games</a></li>
		</ul>	
		<ul class="nav navbar-nav navbar-right">
			 
			<?php					
				if (isset($_SESSION['username'])){
					echo '<li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> ' . $_SESSION['username'] . '</a></li>	
						<li><a href="./scripts/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a> </li>';
				}
				else{
					echo '<li> <a href="register.php">Register</a></li>
						<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
				}
			?>				
		</ul>
	</div>		
</nav>
<div class="container">
	<div class="form-group form-inline">
	<select class="form-control" id="sel">
		<?php
			$nba = '';
			$nfl = '';
			$mlb = '';
			$all = '';
			switch ($_REQUEST['sport']) {
				case 'nba': $nba = 'selected'; break;
				case 'nfl': $nfl = 'selected'; break;
				case 'mlb': $mlb = 'selected'; break;
				default:
					$all = 	'selected';
			}
			echo '<option value="all" '. $all . '>All</option>
				<option value="nba" '. $nba . '>NBA</option>
				<option value="nfl" '. $nfl . '>NFL</option>
				<option value="mlb" '. $mlb . '>MLB</option>'
		?>
	</select>
	<input class="form-control" id="search" type="text" placeholder="Search Games..">
	</div>
	<?php
		require_once('path.inc');
		require_once('get_host_info.inc');
		require_once('rabbitMQLib.inc');
		$client = new rabbitMQClient("RabbitMQ.ini","BackendServer");

		$request = array();
		$request['type'] = "games";
		/*if (isset($_REQUEST['sport'])) {
			$request['sport'] = $_REQUEST['sport'];
		}*/
		$response = $client->send_request($request);
		$games = json_decode($response, true);
		
		require_once('scripts/functions.php');
		
		$count = 0;					
		$nba = getPrepareGameSchedule($games['nba'], 50);
		$nfl = getPrepareGameSchedule($games['nfl'], 50);
		$mlb = getPrepareGameSchedule($games['mlb'], 50);	
		
		if ($nba[1] != null) {
			echo '<div class="panel panel-default bk" id="nbaPanel">            
				<div class="panel-heading">Basketball</div>					
				<table class="table">  
				<tbody id="nbaTable">
				<tr><td>Upcoming Games</td><td>Date Time</td></tr>'
				. $nba[0] . '</tbody></table></div>';
				
			echo $nba[1];
		}
		if ($nfl[1] != null) {
			echo '<div class="panel panel-default bk" id="nflPanel">   
				<div class="panel-heading">Football</div>
				<table class="table">           
				<tbody id="nflTable">
				<tr><td>Upcoming Games</td><td>Date Time</td></tr>'
				. $nfl[0] . '</tbody></table></div>';
				
			echo $nfl[1];
		}
		if ($mlb[1] != null) {
			echo '<div class="panel panel-default bk" id="mlbPanel">
				<div class="panel-heading"><Baseball</div>
				<table class="table">           
				<tbody id="mlbTable">
				<tr><td>Upcoming Games</td><td>Date Time</td></tr>'
				. $mlb[0] . '</tbody></table></div>';
				
			echo $mlb[1];
		}
	?>
</div>
<div id="response" class="modal fade" role="dialog">
	<div class="modal-dialog">		
		<div id="responseBody" class="modal-body"></div>
	</div>
</div>
</body>
</html>
