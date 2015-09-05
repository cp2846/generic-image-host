<?php 
include("includes/sessioncheck.php"); 
?>

<?php
//This is the registration script.
//It checks to see if users are already registered, and if the user's username is valid or not.




$takenError = $passwordError = $usernameError = $requiredError = $successMessage = "";

include("includes/db_connect.php");
if (isset($_POST["username"]) && isset($_POST["pass"])){
	//get sanitized user input
	$username = mysqli_real_escape_string($dbConnect, $_POST["username"]);
	$password = mysqli_real_escape_string($dbConnect, $_POST["pass"]);
	$passwordConfirm = mysqli_real_escape_string($dbConnect, $_POST["passConfirm"]);

	//get hash of password for database storage
	$dbPassword = password_hash($password, PASSWORD_BCRYPT);
	//query the database
	$sqlStatement = "SELECT username FROM users WHERE username = '".$username."'";
	$sqlQuery = mysqli_query($dbConnect, $sqlStatement);
	//check if username is taken
	if (mysqli_num_rows($sqlQuery)>0){
		$takenError = "<p class = \"error\">Username is already taken.</p>";
	} else if ($password != $passwordConfirm){ //check if passwords match
		$passwordError = "<p class = \"error\">Passwords do not match.</p>";
	} else if (empty($username) or empty($password)) {
		$requiredError = "<p class = \"error\">All fields are required.</p>"; //check if required fields are filled
	} else if (!preg_match("/[A-Za-z0-9]+/",$username)) {
		$usernameError = "<p class = \"error\">Username is invalid; only letters and numbers are allowed.</p>"; //check if username uses valid characters
	}else if (strlen($username)>30){
		$usernameError = "<p class = \"error\">Username is invalid; max length 30 characters.</p>";
	} else {
		$insertQuery = "INSERT INTO users(id, username, password) VALUES (NULL, '$username', '$dbPassword')";
		$insertGallery = "INSERT INTO galleries(galleryid, permissions, user, password, galleryname) VALUES (NULL, NULL, '$username', NULL, 'Main')";
		mysqli_query($dbConnect, $insertQuery);
		mysqli_query($dbConnect, $insertGallery);
		$successMessage = "<p>Success! Please head to the <a href = 'login.php'>login</a> page to check out your new account!</p>";
	}
}
?>


<!doctype html>
<html>
	<head>
		<title><?php include ("includes/sitetitle.php"); ?> - Register</title>
		<link rel = "stylesheet" type = "text/css" href = "style.css">
	</head>

	<body>
		

			<div class = "container">
				<div id="titlediv">
					<h1><?php include ("includes/logo.php"); ?><br><?php include ("includes/sitetitle.php"); ?></h1>
				</div>
			<div id="navbar">
				<ul>
					<li><a class ="navbutton fadered" href ="home.php">HOME</a></li>
					<li><a class ="navbutton fadegreen" href ="login.php">LOGIN</a></li>
					<li><a class ="navbutton fadepurple" href ="about.php">ABOUT</a></li>
				</ul>
			</div>
				<div id = "upload"><h2>Create New Account</h2></div>
				<div id="logincontainer">
						<?php 
						echo $takenError;
						echo $requiredError;
						echo $usernameError;
						echo $passwordError;
						echo $successMessage 
						?>
					<form action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "post">
						<p>Choose Username:</p> 
						<input type = "text" name = "username" class = "formbox">
						<p>Choose Password:</p>
						<input type ="password" name = "pass" class = "formbox">
						<p>Confirm Password:</p>
						<input type ="password" name = "passConfirm" class = "formbox">
						<br><br><br>
						<input type = "submit" value = "Register" name ="submit">
					</form>

					<p>Already have an account? <a href = "login.php">Login</a> now and manage your files!</p>

				</div>
			</div>

	</body>
</html>