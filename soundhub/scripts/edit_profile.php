<?php 

include "../classes/user.php";

header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_SESSION['user']) || !isset($_GET)) {
	exit;
}

$account=$_SESSION['user'];

$newpath = "";
if (isset($_FILES['file']['name']) && $_FILES['file']['tmp_name'] != "") {
	
	$imageFileType = strtolower(pathinfo(basename($_FILES['file']['name']),PATHINFO_EXTENSION));
	$newpath = '../images/users/'.$account->login.'.'.$imageFileType;
	$moveResult = move_uploaded_file($_FILES['file']['tmp_name'], $newpath);
	if ($moveResult)
		$account->photo=$account->login.'.'.$imageFileType;	
	
}

if (isset($_GET['phone']))
	$account->phone = $_GET['phone'];
if (isset($_GET['description']))
	$account->description = $_GET['description'];

$result = $account->update();

if ($result === true) {
	
	$_SESSION['msg']['type'] = "alert-success";
	$_SESSION['msg']['text'] = "Changes saved!";
	?>
	
	<?php include "../templates/alert.php"; ?>
	<?php include "../templates/profile.php"; ?>
	
	<?php
	exit;

}
else if ($result != false) {

	$_SESSION['msg']['type'] = "alert-danger";
	$_SESSION['msg']['text'] = "Error occured: ".$result;
	?>
	
	<?php include "../templates/alert.php"; ?>
	<?php include "../templates/profile.php"; ?>
	
	<?php
	exit;

}

$_SESSION['msg']['type'] = "alert-danger";
$_SESSION['msg']['text'] = "Unknown error occured!";
?>

<?php include "../templates/alert.php"; ?>
<?php include "../templates/profile.php"; ?>

<?php
exit;

?>