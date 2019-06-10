<?php
if (!isset($_SESSION))
	session_start();

//session_unset();

?>

<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<meta name="author" content="Недодаєв Владислав"> 
		<meta name="copyright" content="SoundHub.com"> 
		
		<title>SoundHub</title>
		
		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
		<!-- Bootstrap core CSS -->
		<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
		<!-- Material Design Bootstrap -->
		<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.3/css/mdb.min.css" rel="stylesheet">
		
		<link rel="stylesheet" href="styles.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
		
		<!-- JQuery -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<!-- Bootstrap tooltips -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
		<!-- Bootstrap core JavaScript -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/js/bootstrap.min.js"></script>
		<!-- MDB core JavaScript -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.3/js/mdb.min.js"></script>
	</head>

	<body style="background-color: rgba(215, 215, 215, 1); word-wrap: break-word; overflow-y: hidden;">
	
		<div class="row orange lighten-1 mx-0 px-0" style="height: 4rem;">
			
			<?php if (!isset($_SESSION['user'])) { ?>
			
			<a href="index.php" class="col-2 justify-content-center d-flex align-items-center black" style="height: 100%">
				<h1 class="orange-text my-0">SOUNDHUB</h1>
			</a>
			
			<div class="col"></div>
			
			<a href="signin.php" class="col-2 justify-content-center d-flex align-items-center mr-0 <?php if (strtok($_SERVER['REQUEST_URI'], '?')=='/soundhub/signin.php') echo ' orange darken-1'; ?>" style="height: 100%">
				<h5 class="text-dark my-0">SIGN IN</h4>
			</a>
			
			<a href="signup.php" class="col-2 justify-content-center d-flex align-items-center mr-0 <?php if (strtok($_SERVER['REQUEST_URI'], '?')=='/soundhub/signup.php') echo ' orange darken-1'; ?>" style="height: 100%">
				<h5 class="text-dark my-0">CREATE ACCOUNT</h4>
			</a>
			
			<?php } else { ?>
			
			<a id="soundhubbutton" value="templates/home.php" class="menubutton col-2 justify-content-center d-flex align-items-center black" style="height: 100%">
				<h1 class="orange-text my-0">SOUNDHUB</h1>
			</a>
			
			<a id="homebutton" value="templates/home.php" class="menubutton col-1 justify-content-center d-flex align-items-center <?php if (strtok($_SERVER['REQUEST_URI'], '?')=='/soundhub/index.php') echo ' orange darken-1'; ?>" style="height: 100%">
				<h5 class="text-dark my-0">HOME</h4>
			</a>
			
			<a id="librarybutton" value="templates/library.php" class="menubutton col-1 justify-content-center d-flex align-items-center <?php if (strtok($_SERVER['REQUEST_URI'], '?')=='/soundhub/library.php') echo ' orange darken-1'; ?>" style="height: 100%">
				<h5 class="text-dark my-0">LIBRARY</h4>
			</a>
			
			<div class="col">
				<div class="row" style="width:100%;">
					<div class="container justify-content-center d-flex align-items-center text-muted">
						<a id="currentauthor" value="" href="#"></a>
						<span id="currenttrackname">Select music</a>
					</div>
					<div class="container" style="width:100%;">
						<audio id="currentmusic" style="width: 100%; height: 2rem" controls src="">
								Your browser does not support the <code>audio</code> element.
						</audio>
					</div>
				</div>
			</div>
			
			<a id="profilebutton" value="templates/profile.php" class="menubutton col-1 justify-content-center d-flex align-items-center <?php if (strtok($_SERVER['REQUEST_URI'], '?')=='/soundhub/profile.php') echo ' orange darken-1'; ?>" style="height: 100%">
				<h5 class="text-dark my-0">ACCOUNT</h4>
			</a>
			
			<a id="uploadbutton" value="templates/upload.php" class="menubutton col-1 justify-content-center d-flex align-items-center <?php if (strtok($_SERVER['REQUEST_URI'], '?')=='/soundhub/upload.php') echo ' orange darken-1'; ?>" style="height: 100%">
				<h5 class="text-dark my-0">UPLOAD</h4>
			</a>
			
			<a href="scripts/logout.php" class="col-1 justify-content-center d-flex align-items-center" style="height: 100%">
				<h5 class="text-dark my-0">LOGOUT</h4>
			</a>
			
			<?php include "scripts/js.php"; ?>	
			
			<?php } ?>
			
		</div>
		
		<div class = "card bg-white">
		<div class = "content mx-auto my-5" style="background-color: #FFF; width: 75%">
		
		<div id = "contentContainer" class = "container">
		<?php include "templates/alert.php"; ?>