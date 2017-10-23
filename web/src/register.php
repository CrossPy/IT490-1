<!DOCTYPE html>

<html>
	<head>
		<title>NJIT Bookies | Register</title>
		<!--<link rel="stylesheet" type="text/css" href="style.css">-->
		<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous"/>-->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
		
		<script>
			var password = document.getElementById("password"), confirm_password = document.getElementById("confirm_password");

			function validatePassword()
			{
			  	if(password.value != confirm_password.value)
				{
				   	confirm_password.setCustomValidity("Passwords Don't Match");
		  		} 
				else
				{
		   			confirm_password.setCustomValidity('');
		  		}
			}

			password.onchange = validatePassword;
			confirm_password.onkeyup = validatePassword;
		</script>
  	</head>

  	<body>
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
			  <a class="navbar-brand" href="index.php">NJIT Bookies</a>
			</div>
			<ul class="nav navbar-nav">
			  <li><a href="index.php">Home</a></li>
			  <li class="active"><a href="register.php">Register</a></li>
			</ul>	
			<ul class="nav navbar-nav navbar-right">
				<li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> <?php if (isset($username)) {echo "<br/><b>$username</b>";} else {echo "<b>Anonymous</b>";}?></a></li>
				<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
			</ul>
		</div>
	</nav>
	
	<main style="width: 320px; margin: auto;">
		<h1>Register</h1>
		<form method="post" action="./scripts/register.php">
		<table>
		<tbody>
			<tr> 
			<td><label for="email">Email</label></td>
			<td><input type="email" class="form-control" id="email" name="email" required/></td>
			</tr>
			<tr><td><label for="password">Password</label></td>	
			<td><input type="password" class="form-control" id="password" name="password" required/></td></tr>

			<tr><td><label for="confirm_password">Confirm Password</label></td>
			<td><input type="password" class="form-control" id="confirm_password" name="confirm_password" required/></td></tr>

			<tr><td><label for="firstName">First Name</label></td>
				<td><input type="text" class="form-control" id="firstName" name="firstName" required/></td></tr>

			<tr><td><label for="lastName">Last Name</label></td>
				<td><input type="text" class="form-control" id="lastName" name="lastName" required/></td></tr>

			<tr><td><label for="address">Address</label></td>
				<td><input type="text" class="form-control" id="address" name="address" required/></td></tr>

			<tr><td><input type="submit" class="form-control" value="Submit"></td></tr>
		</tbody>
		</table>
		</form>
	</main>
  	</body>
</html>


