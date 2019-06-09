<?php 

session_start();

if (isset($_SESSION['user'])) {
	$_SESSION['msg']['type'] = "alert-info";
	$_SESSION['msg']['text'] = "You are already logged in!";
	header("Location: index.php");
	exit();
}

?>

<?php require "templates/header.php" ?>

<article class="card-body mx-auto" style="max-width: 400px;">
	<h4 class="card-title mt-3 text-center">Sign in</h4>
	
	<form action="scripts/login.php" method="POST">
	<div class="form-group input-group">
		<div class="input-group-prepend">
			<span class="input-group-text"> <i class="fa fa-user"></i> </span>
		</div>
		<input name="login" class="form-control" placeholder="Enter Login or Email" type="text" required>
	</div>
	
	<div class="form-group input-group">
		<div class="input-group-prepend">
			<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
		</div>
		<input name="password" class="form-control" placeholder="Enter Password" type="password" required>
	</div>
	
	<div class="form-group">
		<button type="submit" class="btn btn-primary btn-block">SIGN IN</button>
	</div>
	
	<p class="text-center">Not registered yet? <a href="signup.php">Create account</a> </p>
	</form>
</article>

<?php require "templates/footer.php" ?>