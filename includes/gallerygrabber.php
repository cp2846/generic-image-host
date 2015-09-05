<?php
include("db_connect.php"); //connect to DB
$userID = $_SESSION["id"];
$sqlStatement = "SELECT imageid, thumbname FROM images WHERE userid= '$userID' ORDER BY date DESC"; //statement to be queried
$sqlQuery = mysqli_query($dbConnect, $sqlStatement); // query
if (mysqli_num_rows($sqlQuery)>0){ 
	while ($row = mysqli_fetch_assoc($sqlQuery)){
		//get imagename of image
		$imageID = $row["imageid"]; // get numeric ID of image
		$thumbName = $row["thumbname"];
		echo "<a href='user.php?image=$imageID'><img class = 'thumb' src='$thumbName' /></a>";
	}
	
} else {
	echo "<p>You have no images.</p>";
}
?>