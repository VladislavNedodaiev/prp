<?php 

include "../classes/user.php";
$mysqli = include "../scripts/connectdb.php";

if (!$mysqli) {
	
	if ($mysqli->connect_errno) { 
	
		$_SESSION['msg']['type'] = "alert-danger";
		$_SESSION['msg']['text'] = mysqli_connect_error();
		include "../templates/alert.php";
		exit;
		
	}
	
}

$usr = null;

if (isset($_SESSION['user']))
	$usr=$_SESSION['user'];
else if (!isset($_GET['user_id'])) { 

	$_SESSION['msg']['type']="alert-danger";
	$_SESSION['msg']['text']="No such user can be found!";
	include "../templates/alert.php";
	exit;
	
}
else {

	$usr = new user;

	if (!($usr->getById($_GET['user_id']))) { 
	
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
				<div class="col-4 my-auto"><a href="#" class='buttonjq' value="templates/profile.php?user_id=<?php echo $_SESSION['user']->user_id; ?>"><?php echo $_SESSION['user']->login; ?></a></div>
				<div class="col-8 text-right my-auto">
					<?php if (!($usr->premium)) { ?><a class="buttonjq" value="templates/become_premium.php" href="#"><i class="far fa-star"></i></i> Become a premium user </a><?php } ?>
					<button type="button" value="scripts/edit_profile.php" id="submit_user_edit" class="btn btn-success btn-sm" style="width: 8rem">Save</button>
					<button type="button" value="templates/profile.php" class="btn btn-info btn-sm buttonjq" style="width: 8rem">Cancel</button>
				</div>
			</div>
		</div>
		
		<div class="card-body">
			<div class="row">
				<div class="col-3 border-right">
					<div class="card">
						<div class="card-header text-muted text-center" style="display: none" id="filepath"></div>
						
						<label style="margin: -1px" for="photoinput"><img class="card-img-top" style="cursor: pointer"
							src="<?php
								if ($usr->photo && file_exists("../images/users/".$usr->photo)) echo "images/users/".$usr->photo;
								else echo "images/default_user.jpg";?>" 
							alt="<?php echo $usr->login;?>"></label>
						<input type="file" style="display: none" accept="image/png, image/jpeg" class="form-control-file" name="photoinput" id="photoinput">
						
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
							<div class="col-5 my-auto"><h5 class = "text-muted"><i class="fas fa-phone"></i> Phone: </h5></div>
							<div class="col p-2"><input type="text" class="form-control" id="phoneinput" name="phoneinput" placeholder="Enter your phone" value="<?php echo $usr->phone; ?>"></div>
						</div>
					
					</div>
					
					<div class="container">
					
						<h2>Biography:</h2>
						<div class="container m-2">
							<textarea class="form-control" name="descriptioninput" id="descriptioninput" placeholder="Biography (3000 characters maximum)" maxlength="3000" rows="8"><?php echo $usr->description; ?></textarea>
						</div>
					</div>
				
				</div>
				
			</div>
		</div>
			
	</div>
</div>
<script>



</script>