<!DOCTYPE html>
<html>

<head>
	<title>NJIT Bookies | Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--<link rel="stylesheet" href="style.css">-->
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
				<li class="active"><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
			</ul>
		</div>
	</nav>

	<br><br>
	
	<div style="width: 380px; margin: auto;">
	<div class="well "style="width: 80%; margin: auto;">
	
	<div class="page-header">
		<h1>Login</h1>
	</div>
	<div class="form-group">
		<form method="post" action="./scripts/login.php" method="post">	
			<label for="email">Email</label>
			<input type="text" class="form-control" id="email" name="email" required/>

			<label for="password">Password</label>
			<input type="password" class="form-control" id="password" name="password" required/>
			<br/>
			<button type="submit" class="btn btn-info btn-block"><span class="glyphicon glyphicon-lock"></span> Sign in</button>
		</form>
	</div>
	</div>
	</div>
</body>
</html>


