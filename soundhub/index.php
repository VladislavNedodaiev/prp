<?php require "templates/header.php"; ?>


	<?php 
	if (!isset($_SESSION['user'])) include "templates/home_unauthorized.php";
	else include "templates/home.php";
	?>
	
	
<?php require "templates/footer.php"; ?>