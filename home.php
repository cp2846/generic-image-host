<?php include("includes/sessioncheck.php"); ?>

<!doctype html>
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
				<h1 class="center"><?php include ("includes/logo.php"); ?><br><?php include ("includes/sitetitle.php"); ?> </h1>
				</div>
				<div id="navbar">
					<ul>
						<li><a class ="navbutton fadered" href ="login.php">LOGIN</a></li>
						<li><a class ="navbutton fadegreen" href ="register.php">REGISTER</a></li>
						<li><a class ="navbutton fadeblue" href ="about.php">ABOUT</a></li>
					</ul>
				</div>
				<div id="upload">
				<p class="center">Hey, visitor! If you're new here, then be sure to check out the <a href="about.php">about us</a> page!</p>
				</div>
				<div id= "logincontainer" >
					<form action ="upload-thumbs.php" method = "post" enctype = "multipart/form-data" name="upload" onsubmit="return emptyCheck()">
						<h2>Select image:</h2>
						<input type ="file" name = "toUpload" id ="toUpload" class="button uploadbutton"><br><br><br>
						<input type = "submit" value = "Upload Image" name ="submit" class="button">
					</form>
				</div>
			</div>

		
	</body>
</html>