<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} 
if (isset($_SESSION["id"])) {
	$logged = TRUE;
} else {
	$logged = FALSE;
}
?>

<!doctype html>
<html>
	<head>
		<title><?php include ("includes/sitetitle.php"); ?> - About</title>
		<link rel = "stylesheet" type = "text/css" href = "style.css">
	</head>

	<body>
		
			<div class = "container">
				<div id="titlediv">
					<h1 class ="center"><?php include ("includes/logo.php"); ?><br><?php include ("includes/sitetitle.php"); ?> - About</h1>
				</div>
				<?php if($logged){  //check if user is logged in, render menu as appropriate?>
					<div id="navbar">
						<ul>
							<li><a class ="navbutton fadegreen" href ="user.php">MY GALLERY</a></li>
							<li><a class ="navbutton fadepurple" href ="logout.php">LOGOUT</a></li>
						</ul>
					</div>
				<?php }  else { ?>
					<div id="navbar">
						<ul>
							<li><a class ="navbutton fadered" href ="home.php">HOME</a></li>
							<li><a class ="navbutton fadeblue" href ="login.php">LOGIN</a></li>
							<li><a class ="navbutton fadepurple" href ="register.php">REGISTER</a></li>
						</ul>
					</div>
				<?php } ?>
				<div class="imagecontainer">
					<h2>What is <?php include ("includes/sitetitle.php"); ?>?</h2>
				</div>
				
				<div class="imagecontainer">
					<p><?php include ("includes/sitetitle.php"); ?> is an easy-to-use, open-source image hosting service capable of hosting <b>.png</b>, <b>.gif</b>, and <b>.jpg</b> files.</p>
					<h2>How it works:</h2>
					<p>If you upload any valid image, you will be given a direct link to the image file which you can share with others.</p>		
					<p>When you register an account with <?php include ("includes/sitetitle.php"); ?>, you will be given your own private gallery, which will only be visible to you. Others may only view an image if you provide them with access to the direct link to that image.</p>
				</div>
			</div>

		
	</body>
</html>