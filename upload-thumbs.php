<?php
//This is the upload script. It includes validation for the file size and type.
//The image is assigned a random integer ID from between 00000001 and 99999999.
//If the user is logged in, they are redirected to the user portal. If not, they are redirected directly to the file.
//If POST data is not set, they are redirected to the HOME page.
//In the future, I will integrate this file with the respective forms to display error messages on the same page as the form,
//instead of on a separate page.


if ($_SERVER['REQUEST_METHOD'] == 'POST' && count($_POST) < 1 ) {
	echo "ERROR: No files selected";
}

include("includes/db_connect.php");
$toDatabase = "";
session_start();

if (isset($_SESSION["id"])){ //checks if user is logged in. If so, the image information gets sent to the database.
	$userID = $_SESSION["id"];
	$toDatabase = 1;
}

if (isset($_POST["submit"])){
	$target_dir = "img/";
	$thumb_dir = "thumbs/";
	$target_file = $target_dir . mysql_real_escape_string(basename($_FILES["toUpload"]["name"]));
	$uploadOk = 0;
	//file path
	$info = $_FILES["toUpload"]["tmp_name"];
	//holds extension of the file
	$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	//assign random number to upload - to be used and stored as image ID associated with image
	$imgNumber = rand(00000001,99999999);
	$fileNameWithoutExt = pathinfo($target_file,PATHINFO_FILENAME);
	$newName = $target_dir.$imgNumber."_".basename($_FILES["toUpload"]["name"]); //this becomes the new full name of the image, e.g. img/12345678_imagename.jpg
	$thumbName = $thumb_dir.$imgNumber."_".basename($_FILES["toUpload"]["name"], $fileType)."png";


	//rudimentary validation

	$check = getimagesize($info);
	
	if($check == false){
		echo "File is not an image.<br>";
		$uploadOk = 0;
	}

	// check size
	else if ($_FILES["toUpload"]["size"] > 8000000){
		echo "Sorry, your file is too large.<br>";
		$uploadOk = 0;
	}
	//certain formats only
	else if($fileType != "jpg" && $fileType != "png" && $fileType != "gif" && $fileType != "jpeg"){
		echo "ERROR: Only JPG, JPEG, PNG & GIF files allowed<br>";
		$uploadOk = 0;
	} else {
		$uploadOk = 1;
	}
	
	if($uploadOk === 1){
		//copy file to img directory
		copy($info, $newName);
		#####################
		#CREATE THUMBNAIL IMAGES #
		#####################
		
		switch($fileType){
			case "jpg":
				$thumb = imagecreatefromjpeg($info);
				break;
			case "jpeg":
				$thumb = imagecreatefromjpeg($info);
				break;
			case "gif":
				$thumb = imagecreatefromgif($info);
				break;
			case "png":
				$thumb = imagecreatefrompng($info);
				break;
		}
		
		list($width, $height) = getimagesize($info);
		$thumbWidth = 200;
		$thumbHeight = 200;
		$thumbnail = imagecreatetruecolor($thumbWidth,$thumbHeight);
		imagealphablending($thumbnail, false);
		imagecopyresized($thumbnail, $thumb, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);
		imagepng($thumbnail, $thumbName);
		
		if($toDatabase === 1){
			$insertQuery = "INSERT INTO images(imageid, userid, imagename, thumbname) VALUES('$imgNumber', '$userID', '$newName','$thumbName')";
			mysqli_query($dbConnect, $insertQuery);
			header("Location: user.php?image=$imgNumber");
		} else {
			header("Location: $newName");
		}
	}
} else {
	header ("Location: home.php");
}

?>
