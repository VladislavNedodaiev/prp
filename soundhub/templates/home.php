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

$ttrack = new track;
$tracks['track'] = $ttrack->getAll();

$usrtracks = NULL;
if ($tracks['track']) {
	foreach($tracks['track'] as &$tt) {

		$usrtrack = new user;
		$usrtrack->loadById($tt->user_id);
		
		$usrtracks[$tt->track_id]=$usrtrack;

	}
}
$tracks['user']=$usrtracks;

?>

<div class="container mx-0 px-0" style="min-height: 25rem;">

	<?php 
	if ($tracks['track']) {
		foreach($tracks['track'] as &$tt) { 
	?>
	<div class="row mx-0 px-0">
		<div class="col-1">
			<a href="#" value="templates/profile.php?user_id=<?php echo $tt->user_id; ?>" class="buttonjq">
			<img class="card-img-top"
				 src="<?php
					 if ($tracks['user'][$tt->track_id]->photo && file_exists($tracks['user'][$tt->track_id]->photo)) echo $tracks['user'][$tt->track_id]->photo;
					 else echo "images/default_user.jpg";?>" 
				 alt="<?php echo $tracks['user'][$tt->track_id]->login;?>">
			</a>
		</div>
		<div class="col">
			<div class="container justify-content-center d-flex align-items-center text-muted">
				<a id="trackauthor" value="templates/profile.php?user_id=<?php echo $tt->user_id; ?>" href="#"></a>
				<span><?php echo $tt->title; ?></span></a>
			</div>
			<div class="container" style="width:100%;">
				<audio id="track" style="width: 100%; height: 2rem" controls src="<?php echo 'music/'.$tt->audio; ?>">
						Your browser does not support the <code>audio</code> element.
				</audio>
			</div>
		</div>
	</div>
	<?php 
		}
	} 
	?>
	<div class="col-4">
		<div class="container">
		</div>
		<div class="container">
		</div>
		<div class="container">
		</div>
	</div>
</div>