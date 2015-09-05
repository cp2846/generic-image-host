<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// if user is already logged in, redirect to user portal
if(isset($_SESSION["username"]) && isset($_SESSION["id"])){
	header ("Location: user.php");
}
?>
