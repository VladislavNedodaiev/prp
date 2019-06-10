<?php

class track {
	
	var $track_id;
	var $user_id;
	var $genre_id;
	var $title;
	var $post_date;
	var $duration;
	var $audio;
	
	// set from query result
	function set_from_qresult($res) {
		
		$this->track_id = $res['track_id'];
		$this->user_id = $res['user_id'];
		$this->genre_id = $res['genre_id'];
		$this->title = $res['title'];
		$this->post_date = $res['post_date'];
		$this->duration = $res['duration'];
		$this->audio = $res['audio'];
		
	}
	
	function getById ($id) {
		
		$ttrack = NULL;
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return $ttrack;
		
		if ($result = $mysqli->query("SELECT `track`.* FROM `track` WHERE `track`.`track_id`='".$id."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

				$ttrack = new track;
				$ttrack ->set_from_qresult($res);
				return $ttrack;
				
			}
		}
		
		return $ttrack;
		
	}
	
	function loadById ($id) {
		
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return mysqli_connect_error();
		
		if ($result = $mysqli->query("SELECT `track`.* FROM `track` WHERE `track`.`track_id`='".$id."';")) {
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
		
		if ($mysqli->query("INSERT INTO `track`(`user_id`, `genre_id`, `title`, `duration`, `audio`) ".
						   "VALUES (".
						   "'".$this->user_id."', ".
						   "'".$this->genre_id."', ".
						   "'".$this->title."', ".
						   "'".$this->duration."', ".
						   "'".$this->audio."');"))  {
		
			return true;
		
		}

		return false;
		
	}
	
	function update() {

		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return mysqli_connect_error();
		
		if ($mysqli->query("UPDATE `track` SET "
						   ."`user_id`='".$this->user_id."', "
						   ."`genre_id`='".$this->genre_id."', "
						   ."`title`='".$this->title."', "
						   ."`duration`='".$this->duration."', "
						   ."`audio`='".$this->audio."' "
						   ."WHERE `track_id`=".$this->track_id.";"))
			return true;
		
		return false;
		
	}
	
	function remove() {
		
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return mysqli_connect_error();
		
		if ($mysqli->query("DELETE FROM `track` WHERE `track`.`track_id`='".$this->track_id."';"))
			return true;
		
		return false;
		
	}
	
}

?>