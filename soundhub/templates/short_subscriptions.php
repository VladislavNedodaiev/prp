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

$sscription = new subscription;
$subscriptions['subscription'] = $sscription->getFromToByLenFromUser(0, 3, $_SESSION['user']->user_id);

$usrsubscrs = NULL;
if ($subscriptions['subscription']) {
	foreach($subscriptions['subscription'] as &$sscr) {

		$usersubscr = new user;
		$usersubscr->loadById($sscr->user_id);
		
		$usrsubscrs[$sscr->subscription_id]=$usersubscr;

	}
}
$subscriptions['user']=$usrsubscrs;

?>

<div class="row mx-0 px-0 border-bottom">
	<div class="col my-auto">
		<h2>Subscriptions</h2>
	</div>
	<div class="col text-right my-auto">
		<a value="templates/subscriptions.php" href="#" class="buttonjq"><h4 class="text-muted">See more</h4></a>
	</div>
</div>

<?php 
if ($subscriptions['subscription']) {
	foreach($subscriptions['subscription'] as &$scription) { 
?>
<div class="row mx-0 px-0">
	<div class="col">
	
<div class="card d-inline-block m-3" style="width: 18rem;">

	<a href="#" class="buttonjq" value="templates/profile?user_id=<?php $scription->user_to_id; ?>">
	
	<img class="card-img-top" src="<?php
					 if ($subscriptions['user'][$scription->subscription_id]->photo && file_exists($subscriptions['user'][$scription->subscription_id]->photo)) echo $subscriptions['user'][$scription->subscription_id]->photo ;
					 else echo "images/default_user.png";?>" 
				alt="<?php echo $subscriptions['user'][$scription->subscription_id]->login; ?>">
	</a>
	
	<div class="card-header text-center">
		<div class="row">
			<div class="col text-center">
				<a href="#" class="buttonjq" value="templates/profile.php?user_id=<?php echo $scription->user_to_id; ?>"><?php echo $subscriptions['user'][$scription->subscription_id]->login; ?></a>
			</div>
		</div>
	</div>
	
</div>
	
<?php 
	}
} 
?>