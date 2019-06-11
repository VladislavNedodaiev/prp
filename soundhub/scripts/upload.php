<?php 

include "../classes/user.php";
include "../classes/track.php";

header('Content-Type: text/html; charset=utf-8');
session_start();

if (!isset($_SESSION['user']) || !isset($_POST)) {
	exit;
}

$ttrack= new track;

$newpath = "";
if (isset($_FILES['uploadtrack']['name']) && $_FILES['uploadtrack']['tmp_name'] != "") {
	
	$imageFileType = strtolower(pathinfo(basename($_FILES['uploadtrack']['name']),PATHINFO_EXTENSION));
	$newpath = '../music/'.$_FILES['uploadtrack']['tmp_name'].'.'.$imageFileType;
	$moveResult = move_uploaded_file($_FILES['uploadtrack']['tmp_name'], $newpath);
	if ($moveResult)
		$ttrack->audio=$newpath;	
	
}

if (isset($_POST['title']))
	$ttrack->title = $_POST['title'];
if (isset($_POST['genre_id']))
	$ttrack->description = $_POST['genre_id'];
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
$_SESSION['msg']['text'] = "Unknown error occured!";
?>

<?php include "../templates/alert.php"; ?>
<?php include "../templates/home.php"; ?>

<?php
exit;

?>