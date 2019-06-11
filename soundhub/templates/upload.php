<?php 

if (!class_exists('user'))
	include "../classes/user.php";
if (!class_exists('track'))
	include "../classes/track.php";
if (!class_exists('playlist'))
	include "../classes/playlist.php";
if (!class_exists('music'))
	include "../classes/music.php";
if (!class_exists('genre'))
	include "../classes/genre.php";

if (isset($_SESSION))
	session_start();

$g = new genre;
$genres = $g->getAll();

$p = new playlist;
$playlists = $p->getPlaylistsByUserId($_SESSION['user']->user_id);

?>

<article class="card-body mx-auto" style="max-width: 400px;">
	<h4 class="card-title mt-3 text-center">Upload music</h4>
	
	<div class="form-group input-group">
		<div class="input-group-prepend">
			<span class="input-group-text"> <i class="fas fa-font"></i> </span>
		</div>
		<input name="uploadtrackname" id="uploadtrackname" class="form-control" placeholder="Track name" type="text" required>
	</div>
	
	<div class="form-group">
		<label for="uploadgenre">Choose genre</label>
		<select id="uploadgenre" name="uploadgenre" class="form-control" required>
			<option value="" disabled selected>Genre</option>
			<?php
			foreach($genres as &$gen) {
			?>
			<option value="<?php echo $gen->genre_id;?>"><?php echo $gen->title;?></option>
			<?php
			}
			?>
		</select>
	</div>
	
	<div class="form-group">
		<label for="uploadplaylist">Choose playlist</label>
		<select id="uploadplaylist" name="uploadplaylist" class="form-control" required>
			<option value="0" selected>All</option>
			<?php
			foreach($playlists as &$pllst) {
			?>
			<option value="<?php echo $pllst->playlist_id;?>"><?php echo $pllst->title;?></option>
			<?php
			}
			?>
		</select>
	</div>
	
	<input type="file" accept="audio/*" class="form-control-file" name="uploadtrack" id="uploadtrack">
	<br>
	<div class="form-group">
		<button type="button" id="submit_upload" value="scripts/upload.php?" class="btn btn-primary btn-block">Upload</button>
	</div>
	
</article>