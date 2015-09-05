<?php include("includes/sessioncheck.php"); ?>


<?php
$errors = " ";

if(isset($_POST["username"])){  //grab POST data from HTML form element with name "username"
	//connect to database
	include_once("includes/db_connect.php");
	//get input from HTML form
	$username = $_POST["username"];
	$pass = $_POST["pass"];
	//sanitize input
	$username = mysqli_real_escape_string($dbConnect, $username);
	$pass = mysqli_real_escape_string($dbConnect, $pass);
	//query the database
	$sqlStatement = "SELECT id, username, password FROM users WHERE username = '$username' LIMIT 1";
	$sqlQuery = mysqli_query($dbConnect, $sqlStatement);
	$sqlRow = mysqli_fetch_row($sqlQuery);
	//fetch info from table rows
	$userID = $sqlRow[0];
	$dbUsername = $sqlRow[1];
	$dbPassword = $sqlRow[2];
	
	if($username == $dbUsername && password_verify($pass,$dbPassword)){
		//set session vars
		$_SESSION["username"] = $dbUsername;
		$_SESSION["id"] = $userID;
		//redirect
		header("Location: user.php");
		
		
	} else {
		//error message
		$errors = "<p class = \"error\">Incorrect username or password.</p>";
	}
	
}

?>

<!doctype html>
<html>
	<head>
		<title><?php include ("includes/sitetitle.php"); ?> - Login</title>
		<link rel = "stylesheet" type = "text/css" href = "style.css">
	</head>

	<body>
		
			

			<div class = "container">
			
				<div id="titlediv">
					<h1 class="center"><?php include ("includes/logo.php"); ?><br><?php include ("includes/sitetitle.php"); ?></h1>
				</div>
				<div id="navbar">
					<ul>
						<li><a class ="navbutton fadered" href ="home.php">HOME</a></li>
						<li><a class ="navbutton fadegreen" href ="register.php">REGISTER</a></li>
						<li><a class ="navbutton fadeblue" href ="about.php">ABOUT</a></li>
					</ul>
				</div>
				<div id="upload">
					<h2>Login</h2>
				</div>
				
				<div id = "logincontainer">
					<form id="login" action="login.php" method="post" enctype="multipart/form-data">
						<?php echo $errors; ?>
						<p>Username:</p> 
						<input type="text" name="username" class = "formbox"><br>
						<p>Password:</p>
						<input type ="password" name="pass" class = "formbox"><br><br>
						<input name="submit" type="submit" value="Login" class="button">
					</form>

					<p>Don't have an account? <a href = "register.php">Register</a> today and manage your files!</p>

				</div>
			</div>

		
	</body>
</html>