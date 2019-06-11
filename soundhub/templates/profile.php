<?php 

if (!class_exists('user'))
	include "../classes/user.php";
if (!class_exists('track'))
	include "../classes/track.php";
if (!class_exists('playlist'))
	include "../classes/playlist.php";
if (!class_exists('tu_like'))
	include "../classes/tu_like.php";

$mysqli = include "../scripts/connectdb.php";

if (!$mysqli) {
	
	if ($mysqli->connect_errno) { 
	
		$_SESSION['msg']['type']="alert-danger";
		$_SESSION['msg']['text']=mysqli_connect_error();
		include "../templates/alert.php";
		exit;
		
	}
	
}

$usr = null;

if (isset($_SESSION['user']) && !isset($_POST['user_id']) || 
	isset($_SESSION['user']) && isset($_POST['user_id']) && $_SESSION['user']->user_id == $_POST['user_id'])
	$usr=$_SESSION['user'];
else if (!isset($_POST['user_id'])) { 

	$_SESSION['msg']['type']="alert-danger";
	$_SESSION['msg']['text']="No such user can be found!";
	include "../templates/alert.php";
	exit;
	
}
else {

	$usr = new user;

	if (!($usr->getById($_POST['user_id']))) { 
	
		$_SESSION['msg']['type']="alert-danger";
		$_SESSION['msg']['text']="No such user can be found!";
		include "../templates/alert.php";
		exit;
		
	}
	
}

?>

<div class="justify-content-center d-flex align-items-center">
	<div class="card" style="width: 60rem;">
		<div class="card-header">
			<div class="row">
				<div class="col-8 my-auto"><a href="#" class='buttonjq' value="templates/profile.php?user_id=<?php echo $_SESSION['user']->user_id; ?>"><?php echo $_SESSION['user']->login; ?></a></div>
				<div class="col text-right my-auto">
				<?php if (isset($_SESSION['user']) && $_SESSION['user']->user_id == $usr->user_id && !($usr->premium)) echo '<a class="buttonjq" value="templates/become_premium.php" href="#"><i class="far fa-star"></i></i> Become a premium user </a>'; 
					  if (isset($_SESSION['user']) && $_SESSION['user']->user_id == $usr->user_id) echo '<a class="buttonjq" value="templates/edit_profile.php" href="#"><i class="fas fa-pencil-alt"></i> Edit</a>';?>
				</div>
			</div>
		</div>
		
		<div class="card-body">
			<div class="row">
				<div class="col-3 border-right">
					<div class="card">
					
						<img class="card-img-top"
							src="<?php
								if ($usr->photo && file_exists($usr->photo)) echo $usr->photo;
								else echo "images/default_user.jpg";?>" 
							alt="<?php echo $usr->login;?>">
						
						<div class="card-header text-center">
							<i class="far fa-calendar-alt"></i><small class = "text-muted"> Registered: <?php echo substr($usr->register_date, 0, 10); ?> </small>
						</div>
						
						<div class="card-header text-center">
							<i class="far fa-thumbs-up"></i><small class = "text-muted"> Total likes: <?php echo $usr->getTotalLikes(); ?> </small>
						</div>
						
						<div class="card-header text-center">
							<i class="far fa-heart"></i><small class = "text-muted"> Total followers: <?php echo $usr->getTotalFollowers(); ?> </small>
						</div>
						
					</div>
				</div>
				
				<div class="col">
				
					<div class="container">
					
						<h2>Contacts:</h2>
					
						<div class="row m-2 border-bottom">
							<div class="col-5 my-auto"><h5 class = "text-muted"><i class="far fa-envelope"></i> Email: </h5></div>
							<div class="col my-auto"><h5><?php echo $usr->email; ?></h5></div>
						</div>
						<div class="row m-2 border-bottom">
							<div class="col-5 my-auto"><h5 class = "text-muted"><i class="fas fa-phone"></i> Phone: </h5></div>
							<?php if ($usr->phone) { ?>
							<div class="col my-auto"><h5><?php echo $usr->phone; ?></h5></div>
							<?php } else { ?>
							<div class="col my-auto"><h5 class = "text-muted"><i>No information</i></h5></div>
							<?php } ?>
						</div>
					
					</div>
					
					<?php if ($usr->description && $usr->description != "") { ?>
					<div class="container">
					
						<h2>Biography:</h2>
						<h5><?php echo $usr->description; ?></h5>
					
					</div>
					<?php } ?>
				
				</div>
			</div>
		</div>
		
		<?php include "../templates/short_likes.php"; ?>
		<?php include "../templates/short_playlists.php"; ?>
		<?php include "../templates/short_subscriptions.php"; ?>
	</div>
</div>