<?php 

include "../classes/user.php";
include "../classes/track.php";

header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_SESSION['user']) || !isset($_GET)) {
	exit;
}

$ttrack= new track;

$newpath = "";
if (isset($_FILES['file']['name']) && $_FILES['file']['tmp_name'] != "") {
	
	$imageFileType = strtolower(pathinfo(basename($_FILES['file']['name']),PATHINFO_EXTENSION));
	$newpath = hash('md5', $_FILES['file']['tmp_name']);
	$newpath = $newpath.'.'.$imageFileType;
	$moveResult = move_uploaded_file($_FILES['file']['tmp_name'], $newpath);
	if ($moveResult)
		$ttrack->audio=$newpath;	
	
}

if (isset($_GET['title']))
	$ttrack->title = $_GET['title'];
if (isset($_GET['genre_id']))
	$ttrack->genre_id = $_GET['genre_id'];
$ttrack->user_id = $_SESSION['user']->user_id;

$result = $ttrack->insert();

if ($result === true) {
	
	$_SESSION['msg']['type'] = "alert-success";
	$_SESSION['msg']['text'] = "Track added!";
	?>
	
	<?php include "../templates/alert.php"; ?>
	<?php include "../templates/home.php"; ?>
	
	<?php
	exit;

}
else if ($result != false) {

	$_SESSION['msg']['type'] = "alert-success";
	$_SESSION['msg']['text'] = "Error occured: ".$result;
	?>
	
	<?php include "../templates/alert.php"; ?>
	<?php include "../templates/home.php"; ?>
	
	<?php
	exit;

}

$_SESSION['msg']['type'] = "alert-danger";
$_SESSION['msg']['text'] = "Unknown error occured!".$result;
?>

<?php include "../templates/alert.php"; ?>
<?php include "../templates/home.php"; ?>

<?php
exit;

?>