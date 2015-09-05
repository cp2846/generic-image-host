<?php
//This is the image deletion script. 
//If there is a row in the database corresponding to the user's ID and the
//image ID, the image and corresponding info will be deleted from the database and the site altogether.
//If not, the user will be redirected to the user page.
//If the user is not logged in, they are redirected to the login page.
//If an invalid user/image ID combination occurs, nothing happens, because
//no mySQLi row is returned from the database. The user is simply redirected to the user page.

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//check if user is logged in
if (!isset($_SESSION["id"])) {
	header ("Location: login.php"); //if not, redirect to login
} else {
	$userID = $_SESSION["id"];
}
include("includes/db_connect.php"); //connect to database

function deleteImage($image){
	unlink("$image"); //delete image from directory
	$sqlDelete= "DELETE FROM images WHERE imagename = '$image'"; 
	mysqli_query($GLOBALS['dbConnect'], $sqlDelete); //delete database entry
}		
if (isset($_GET["id"])) {
	$enteredID = mysqli_real_escape_string($dbConnect, $_GET["id"]); 
	$sqlStatement = "SELECT imageid, userid, imagename, thumbname FROM images WHERE imageid = '$enteredID' and userid = '$userID'";
	$sqlQuery = mysqli_query($dbConnect, $sqlStatement);
	$sqlRow = mysqli_fetch_row($sqlQuery);
	$imageName = $sqlRow[2];
	$thumbName = $sqlRow[3];
	if (mysqli_num_rows($sqlQuery)>0){
		deleteImage($imageName);
		deleteImage($thumbName);
	}	else {
		header ("Location: user.php");
	}
}
//return to latest upload image
$sqlReturn =  "SELECT * FROM images WHERE userid= '$userID' ORDER BY date DESC LIMIT 1"; // grab latest-uploaded image
$returnQuery = mysqli_query($dbConnect, $sqlReturn);
if (mysqli_num_rows($returnQuery)>0){
	$row = mysqli_fetch_assoc($returnQuery);
	$returnID = $row["imageid"];
	header ("Location: user.php?image=$returnID");
} else {
	header ("Location: user.php"); //if no more images, redirect to user page
}


?> 
