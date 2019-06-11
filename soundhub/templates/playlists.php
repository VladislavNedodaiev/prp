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

$pllst = new playlist;
$playlists['playlist'] = $pllst->getPlaylistsByUserId($_SESSION['user']->user_id);

$usrplaylists = NULL;
if ($playlists['playlist']) {
	foreach($playlists['playlist'] as &$playlst) {

		$userpllst = new user;
		$userpllst->loadById($playlst->user_id);
		
		$usrplaylists[$playlst->playlist_id]=$userpllst;

	}
}
$playlists['user']=$usrplaylists;

?>

<div class="container mx-0 px-0" style="min-height: 25rem;">
	<div class="row mx-0 px-0 border-bottom">
		<div class="col my-auto">
			<h2>Playlists</h2>
		</div>
		<div class="col text-right my-auto">
			<a value="templates/library.php" href="#" class="buttonjq"><h4 class="text-muted">Back to library</h4></a>
		</div>
	</div>

	<?php 
	if ($playlists['playlist']) {
		foreach($playlists['playlist'] as &$plist) { 
	?>
	<div class="row mx-0 px-0">
		<div class="col">
		
	<div class="card d-inline-block m-3" style="width: 10rem;">

		<a href="#" class="buttonjq" value="templates/playlist?playlist_id=<?php $plist->playlist_id; ?>">
		
		<img class="card-img-top" style="cursor: pointer"
			src="<?php
				if ($usr->photo && file_exists("../images/playlists/".$usr->photo)) echo "images/playlists/".$usr->photo;
				else echo "images/default_user.jpg";?>" 
			alt="<?php echo $usr->login;?>">
		</a>
		
		<div class="card-header text-center">
			<div class="row">
				<div class="col text-center">
					<a href="#" class="buttonjq" value="templates/profile.php?user_id=<?php echo $plist->user_id; ?>"><small class = "text-muted"> <?php echo $playlists['user'][$plist->playlist_id]->login; ?></small></a>
				</div>
			</div>
			<div class="row">
				<div class="col my-auto"><?php echo $plist->title; ?></div>
			</div>
		</div>
		
	</div>
		
	<?php 
		}
	} 
	?>
</div>