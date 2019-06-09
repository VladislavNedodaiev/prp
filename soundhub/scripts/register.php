<?php

if (!isset($_SESSION))
	session_start();

if (isset($_POST['user'])) {
	
	header("Location: ../index.php");
	exit;
	
}

if (!isset($_POST['login'])) {
	
	$_SESSION['msg']['type'] = "alert-warning";
	$_SESSION['msg']['text'] = "Login field must be filled";
	header("Location: ../signup.php");
	exit;
	
}

if (!isset($_POST['email'])) {
	
	$_SESSION['msg']['type'] = "alert-warning";
	$_SESSION['msg']['text'] = "Email field must be filled";
	header("Location: ../signup.php");
	exit;
	
}

if (!isset($_POST['password'])) {
	
	$_SESSION['msg']['type'] = "alert-warning";
	$_SESSION['msg']['text'] = "Password field must be filled";
	header("Location: ../signup.php");
	exit;
	
}

if (!isset($_POST['password_rep'])) {
	
	$_SESSION['msg']['type'] = "alert-warning";
	$_SESSION['msg']['text'] = "Both password fields must be filled";
	header("Location: ../signup.php");
	exit;
	
}

if ($_POST['password_rep'] != $_POST['password']) {
	
	$_SESSION['msg']['type'] = "alert-warning";
	$_SESSION['msg']['text'] = "Passwords do not match";
	header("Location: ../signup.php");
	exit;
	
}

include "../classes/user.php";

$account = new user;

$result = $account->register($_POST['login'], $_POST['email'], $_POST['password']);

if ($result === $_POST['login']) {
	
	$_SESSION['msg']['type'] = "alert-danger";
	$_SESSION['msg']['text'] = "Account with current login already exists!";
	header("Location: ../signup.php");
	exit;
	
} else if ($result === $_POST['email']) {
	
	$_SESSION['msg']['type'] = "alert-danger";
	$_SESSION['msg']['text'] = "Account with current email already exists!";
	header("Location: ../signup.php");
	exit;
	
} else if ($result != false && $result != true) {
	
	$_SESSION['msg']['type'] = "alert-danger";
	$_SESSION['msg']['text'] = "Error occured! ".$result;
	header("Location: ../signup.php");
	exit;
	
} else if ($result) {
	
	$_SESSION['msg']['type'] = "alert-success";
	$_SESSION['msg']['text'] = "Welcome to the SoundHub, ".$account->login."!";
	$_SESSION['user'] = $account;
	header("Location: ../index.php");
	exit;
	
}

$_SESSION['msg']['type'] = "alert-danger";
$_SESSION['msg']['text'] = "Unknown error occured!";
header("Location: ../signup.php");
exit;



?>