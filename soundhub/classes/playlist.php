<?php

class playlist {
	
	var $playlist_id;
	var $user_id;
	var $title;
	var $post_date;
	var $description;
	var $photo;
	
	// set from query result
	function set_from_qresult($res) {
		
		$this->playlist_id = $res['playlist_id'];
		$this->user_id = $res['user_id'];
		$this->title = $res['title'];
		$this->post_date = $res['post_date'];
		$this->description = $res['description'];
		$this->photo = $res['photo'];
		
	}
	
	function getById ($id) {
		
		$pllst = NULL;
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return $pllst;
		
		if ($result = $mysqli->query("SELECT `playlist`.* FROM `playlist` WHERE `playlist`.`playlist_id`='".$id."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

				$pllst = new playlist;
				$pllst ->set_from_qresult($res);
				return $pllst;
				
			}
		}
		
		return $pllst;
		
	}
	
	function loadById ($id) {
		
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return mysqli_connect_error();
		
		if ($result = $mysqli->query("SELECT `playlist`.* FROM `playlist` WHERE `playlist`.`playlist_id`='".$id."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

				$this->set_from_qresult($res);
				return true;
				
			}
		}
		
		return false;
		
	}
	
	function insert () {
		
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return mysqli_connect_error();
		
		if ($mysqli->query("INSERT INTO `playlist`(`user_id`, `title`, `description`, `photo`) ".
						   "VALUES (".
						   "'".$this->user_id."', ".
						   "'".$this->title."', ".
						   "'".$this->description."', ".
						   "'".$this->photo."');"))  {
		
			return true;
		
		}

		return false;
		
	}
	
	function remove () {
		
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return mysqli_connect_error();
		
		if ($mysqli->query("DELETE FROM `playlist` WHERE `playlist`.`playlist_id`='".$this->playlist_id."';"))  {
		
			return true;
		
		}

		return false;
		
	}
	
	// updates the database 
	function update() {

		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return mysqli_connect_error();
		
		if ($mysqli->query("UPDATE `playlist` SET "
						   ."`title`='".$this->title."', "
						   ."`description`='".$this->description."', "
						   ."`photo`='".$this->photo."' "
						   ."WHERE `playlist_id`=".$this->playlist_id.";"))
			return true;
		
		return false;
		
	}
	
	function getTotalTracks() {
		
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return 0;
		
		if ($result = $mysqli->query("SELECT COUNT(`music`.`music_id`) AS musics FROM `playlist`, `music` WHERE `playlist`.`playlist_id`=`music`.`playlist_id`;")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				return $res['musics'];
			}
		}
		
		return 0;
		
	}
	
	function getPlaylistsByUserId($id) {
		
		$playlists = NULL;
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return $playlists;
		
		if ($result = $mysqli->query("SELECT `playlist`.* FROM `playlist` WHERE `playlist`.`user_id`='".$id."';")) {
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$playlist = new playlist;
				$playlist->set_from_qresult($res);
				
				$playlists[$playlist->playlist_id] = $playlist;
				
			}
		}
		
		return $playlists;
		
	}
	
}

?>