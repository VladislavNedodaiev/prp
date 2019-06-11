<?php

if (!class_exists('user'))
	include "../classes/user.php";
if (!class_exists('track'))
	include "../classes/track.php";
if (!class_exists('playlist'))
	include "../classes/playlist.php";
if (!class_exists('tu_like'))
	include "../classes/tu_like.php";
if (!class_exists('subscription'))
	include "../classes/subscription.php";

if (!isset($_SESSION))
	session_start();

?>

<div class="container mx-0 px-0" style="min-height: 25rem;">

<?php include "../templates/short_likes.php"; ?>
<?php include "../templates/short_playlists.php"; ?>
<?php include "../templates/short_subscriptions.php"; ?>

</div>