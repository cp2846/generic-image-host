<?php
//This is the user portal, where the user can view, upload to, and delete from their gallery. 
//If the user is not logged in, they are automatically redirected to the login page. If the      
//image ID entered in the http GET request doesn't correspond to an image uploaded by the
//current user, an "invalid image ID" message is displayed.
?>

<?php
session_start();
if (!isset($_SESSION["username"])) {
	header ("Location: login.php");
} else {
	$username = $_SESSION["username"] ;
	$userID = $_SESSION["id"];
}
include("includes/db_connect.php");

?> 

<!doctype html>
<?php if (isset($_GET["image"])) {
	$valid = 0;
	$enteredID = mysqli_real_escape_string($dbConnect, $_GET["image"]);
	// check to see if image in GET request corresponds to one uploaded by user
	$sqlStatement = "SELECT imageid, userid, imagename FROM images WHERE imageid = '$enteredID' and userid = '$userID'";
	$sqlQuery = mysqli_query($dbConnect, $sqlStatement);	
	if (mysqli_num_rows($sqlQuery)>0){
		$sqlRow = mysqli_fetch_row($sqlQuery);
		//fetch info from table rows
		$imageid = $sqlRow[0];
		$userid = $sqlRow[1];
		$imageName = $sqlRow[2];
		$valid = 1;
		} 
	}
?>

<html>
	<head>
		<title><?php include ("includes/sitetitle.php"); ?></title>
		<link rel = "stylesheet" type = "text/css" href = "style.css">
	</head>

	<body>
	<script type = "text/javascript">
	function emptyCheck(){
		if(document.forms["upload"]["toUpload"].value == "" || document.forms["upload"]["toUpload"].value == null) {
			alert("No file selected.");
			return false;
		}
		return true;
	}
	</script>
		
			
		<div class = "container">
		<div id="titlediv">
			<h1 class="center"><?php include ("includes/logo.php"); ?><br><?php include ("includes/sitetitle.php"); ?> - <?php echo $username; ?>'s Gallery</h1>
		</div>
		<div id="navbar">
			<ul>
				<li><a class ="navbutton fadered" href ="about.php">ABOUT</a></li>
				<li><a class ="navbutton fadeblue" href ="logout.php">LOGOUT</a></li>
			</ul>
		</div>
			<div class = "imagecontainer">
			<?php 
				if (isset($_GET["image"])) {
					if ($valid == 1){
						//display image or error message
						echo "<a href = '$imageName'><img alt = 'Click to get full-sized image' src = '$imageName' /></a>";
					} else {
						echo "<p class = \"error\">Invalid image ID</p>";
					}
				} else {
					echo "<h2>Welcome back, $username!</h2><p>Click on the 'browse' button OR drag and drop a file into the area below to get started!</p>";
				}
				?>
				</div>
				
				<?php 
				if (isset($_GET["image"])) {
					if ($valid == 1){
						//add section for URL
						echo "<div class = 'imagecontainer'><p>Direct link to image:</p>";
						echo "<input onClick='this.select();' class = 'wide' type = 'text' value = 'http://localhost/melonimg/$imageName'> ";
						echo "<a href = 'delete.php?id=$imageid' onClick = \"return confirm('Are you sure you want to delete this image?')\"><img src='delete.png' class='delete'></a></div>";
					}
				}
				?>
				
				<div class = "formcontainer">
					<form action ="upload-thumbs.php" method = "post" onsubmit = "return emptyCheck()" enctype = "multipart/form-data" name="upload">
						<h2>Select image:</h2>
						<input type ="file" name = "toUpload" id ="toUpload" class="button uploadbutton"><br><br><br>
						<input type = "submit" value = "Upload Image" name ="submit" class="button">
					</form>
				</div>
				
				<div class = "gallerybox">
				<?php include ("includes/gallerygrabber.php"); ?>
				</div>
				
			</div>

		
	</body>
</html>