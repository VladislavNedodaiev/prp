<?php 

session_start();

if (isset($_SESSION['user'])) {
	$_SESSION['msg']['type'] = "info";
	$_SESSION['msg']['text'] = "You are already logged in!";
	header("Location: index.php");
	exit();
}

?>

<?php require "templates/header.php" ?>

<article class="card-body mx-auto" style="max-width: 400px;">
	<h4 class="card-title mt-3 text-center">Create account</h4>
	
	<form action="scripts/register.php" method="POST">
	<div class="form-group input-group">
		<div class="input-group-prepend">
			<span class="input-group-text"> <i class="fa fa-user"></i> </span>
		</div>
		<input name="login" class="form-control" placeholder="Login" type="text" required>
	</div>
	
	<div class="form-group input-group">
		<div class="input-group-prepend">
			<span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
		</div>
		<input name="email" class="form-control" placeholder="Email" type="email" required>
	</div>
	
	<div class="form-group input-group">
		<div class="input-group-prepend">
			<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
		</div>
		<input name="password" class="form-control" placeholder="Enter Password" type="password" required>
	</div>
	<div class="form-group input-group">
		<div class="input-group-prepend">
			<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
		</div>
		<input name="password_rep" class="form-control" placeholder="Repeat Password" type="password" required>
	</div>
	
	<div class="form-group">
		<button type="submit" class="btn btn-primary btn-block">SIGN UP</button>
	</div>
	
	<p class="text-center">Already have an account? <a href="login.php">Sign in</a> </p>                                                                 
	</form>
	
</article>

<?php require "templates/footer.php" ?>