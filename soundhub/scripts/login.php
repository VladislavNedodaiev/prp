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
	header("Location: ../signin.php");
	exit;
	
}

if (!isset($_POST['password'])) {
	
	$_SESSION['msg']['type'] = "alert-warning";
	$_SESSION['msg']['text'] = "Password field must be filled";
	header("Location: ../signin.php");
	exit;
	
}

include "../classes/user.php";

$account = new user;

$result = $account->login($_POST['login'], $_POST['password']);

if ($result != false && $result != true) {
	
	$_SESSION['msg']['type'] = "alert-danger";
	$_SESSION['msg']['text'] = "Error occured! ".$result;
	header("Location: ../signin.php");
	exit;
	
} else if ($result) {
	
	$_SESSION['msg']['type'] = "alert-success";
	$_SESSION['msg']['text'] = "Welcome to the SoundHub, ".$account->login."!";
	$_SESSION['user'] = $account;
	header("Location: ../index.php");
	exit;
	
}

$_SESSION['msg']['type'] = "alert-danger";
$_SESSION['msg']['text'] = "The login or password is wrong, or there is no such user found";
header("Location: ../signin.php");
exit;



?>