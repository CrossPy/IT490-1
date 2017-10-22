<?php
	session_start();
	$username = $_SESSION["username"];

	if (isset($username))
	{
		$loggedIn = True;
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
	</head>

	<body>
		<ul>
			<li style="color:green; border-right: 1px solid #bbb"><a href="index.php"><b>Home</b></a></li>
			<li><a href="register.php">Register</a></li>
			<li><a href="profile.php">Profile</a></li>
			<li style="float:right" class="dropdown">
				
				<?php
					if ($loggedIn == True)
					{
						echo '<html>
							<a href="#" class="dropbtn">Logged in as: $username</a>
							<div class="dropdown-content">	
								<a href="./scripts/logout.php">Logout</a>
			    				</div>
						</html>';
					}
					else
					{
						echo '
						<html>
							<a href="#" class="dropbtn">Logged in as: Anonymous</a>
							<div class="dropdown-content">	
								<a href="login.php">Login</a>
			    				</div>
						</html>';
					}
				?>	
			</li>
		</ul>

		<br><br>
		
		<div>
			<h1>NJIT Bookies</h1>
		<table >
		<tr>
			<td>
				<table class="GamesFrontPage" id="1">
				<tr>
					<th><h1>Football</h1> </th>
				</tr>
				<tr>
					<td> Upcoming sporting Events </td>
				</tr>
				<tr><td>Date Time</td></tr>
				<tr><td>Game 1 10/29/17 01:00PM </td><td><button type="button" > Bet </button></td></tr>
				
			</table>
			</td>

			<td>
				<table class="GamesFrontPage" id="1">
				<tr>
					<th><h1>Basketball</h1> </th>
				</tr>
								<tr>
					<td> Upcoming sporting Events </td>
				</tr>
				<tr><td>Date Time</td></tr>
				<tr><td>Game 1 10/29/17 01:00PM </td><td><button type="button" > Bet </button></td></tr>
			</table>
			</td>

			<td>
				<table class="GamesFrontPage" id="1">
				<tr>
					<th><h1>Baseball</h1> </th>
				</tr>
								<tr>
					<td> Upcoming sporting Events </td>
				</tr>
				<tr><td>Date Time</td></tr>
				<tr><td>Game 1 10/29/17 01:00PM </td><td><button type="button" > Bet </button></td></tr>
			</table>
			</td>
		</tr>
		</table>	


		</div>
	</body>
</html>
