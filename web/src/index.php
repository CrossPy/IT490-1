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
	}
?>

<DOCTYPE html>
<html>
	<head>
		<title>NJIT Bookies</title>
		<link rel="stylesheet" type="text/css" href="style.css">
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
			  <li class="active"><a href="index.php">Home</a></li>
			  <li> <a href="register.php">Register</a></li>
			</ul>	
			<ul class="nav navbar-nav navbar-right">
				<li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> 
					<?php if ($loggedIn == True)
					{
						echo '
							Logged in as: $username</a> </li>	
							<li> <a href="./scripts/logout.php">Logout</a> </li>
			    			
						';
					}
					else
					{
						echo '
							Logged in as: Anonymous</a> </li>
							<li> <a href="login.php">Login</a> </li>';
					}
				?>
				
			</ul>
		</div>
	</nav>


		<br><br>
		<h1>NJIT Bookies</h1>
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">		
				<h1>Football</h1>
				
				
					Upcoming sporting Events 
			
				Date Time
				Game 1 10/29/17 01:00PM <button type="button" class="btn-success btn-md"> Bet </button>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<h1>Basketball</h1>
				
								
					 Upcoming sporting Events
				
				Date Time
				Game 1 10/29/17 01:00PM <button type="button" class="btn-success btn-md"> Bet </button>
				</div>


				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<h1>Baseball</h1> 
				
								
					 Upcoming sporting Events 
				
				Date Time
				Game 1 10/29/17 01:00PM <button type="button" class="btn-success btn-md" > Bet </button>
				

		</div>
	</body>
</html>
