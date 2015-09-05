<?php
//This file creates a dynamic menu based on the current page and session information.


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (basename($_SERVER['PHP_SELF'])== "home.php"){ // home page
	echo '<p><a href="login.php">Login</a> | <a href="register.php">Register</a> | <a href="about.php">About</a></p>';
}
else if (basename($_SERVER['PHP_SELF'])== "login.php"){ // login page
	echo '<p><a href="home.php">Home</a> | <a href="register.php">Register</a> | <a href="about.php">About</a></p>';
}
else if (basename($_SERVER['PHP_SELF']) == "register.php"){ // registration page
	echo '<p><a href="home.php">Home</a> | <a href="login.php">Login</a> | <a href="about.php">About</a></p>';
} 
else if (basename($_SERVER['PHP_SELF']) == "user.php"){ // user page
	echo '<p><a href="logout.php">Logout</a> | <a href="about.php">About</a> </p>';
} 
else if (basename($_SERVER['PHP_SELF']) == "about.php"){ // about page
	if (isset($_SESSION["username"])){
		echo '<p><a href="logout.php">Logout</a> | <a href="user.php">My Gallery</a> </p>';
	} else {
		echo '<p><a href="home.php">Home</a> | <a href="login.php">Login</a> | <a href="register.php">Register</a></p>';
	}
} else {
	if (isset($_SESSION["username"])){
		echo '<p><a href="logout.php">Logout</a> | <a href="about.php">About</a> |<a href="user.php">My Gallery</a> </p>';
	} else {
		echo '<p><a href="home.php">Home</a> | <a href="about.php">About</a> | <a href="login.php">Login</a> | <a href="register.php">Register</a></p> ';
	}
}
?>
