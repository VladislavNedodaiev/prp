<?php

class tu_like {
	
	var $tu_like_id;
	var $user_id;
	var $track_id;
	
	// set from query result
	function set_from_qresult($res) {
		
		$this->tu_like_id = $res['tu_like_id'];
		$this->user_id = $res['user_id'];
		$this->track_id = $res['track_id'];
		
	}
	
	function getById ($id) {
		
		$tulike = NULL;
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return $tulike;
		
		if ($result = $mysqli->query("SELECT `tu_like`.* FROM `tu_like` WHERE `tu_like`.`tu_like_id`='".$id."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

				$tulike = new tu_like;
				$tulike ->set_from_qresult($res);
				return $tulike;
				
			}
		}
		
		return $tulike;
		
	}
	
	function getByUT($uid, $tid) {
		
		$tulike = NULL;
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return $tulike;
		
		if ($result = $mysqli->query("SELECT `tu_like`.* FROM `tu_like` WHERE `tu_like`.`user_id`='".$uid."' AND `tu_like`.`track_id`='".$tid."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

				$tulike = new tu_like;
				$tulike ->set_from_qresult($res);
				return $tulike;
				
			}
		}
		
		return $tulike;
		
	}
	
	function loadById ($id) {
		
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return mysqli_connect_error();
		
		if ($result = $mysqli->query("SELECT `tu_like`.* FROM `tu_like` WHERE `tu_like`.`tu_like_id`='".$id."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

				$this->set_from_qresult($res);
				return true;
				
			}
		}
		
		return false;
		
	}
	
	function loadByFromTo ($uid, $tid) {
		
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return mysqli_connect_error();
		
		if ($result = $mysqli->query("SELECT `tu_like`.* FROM `tu_like` WHERE `tu_like`.`user_id`='".$uid."' AND `tu_like`.`track_id`='".$tid."';")) {
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
		
		if ($this->getByUT($this->$user_id, $this->$track_id))
			return false;
		
		if ($mysqli->query("INSERT INTO `tu_like`(`user_id`, `track_id`) ".
						   "VALUES (".
						   "'".$this->user_id."', ".
						   "'".$this->track_id."');"))  {
		
			return true;
		
		}

		return false;
		
	}
	
	function remove() {
		
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return mysqli_connect_error();
		
		if ($mysqli->query("DELETE FROM `tu_like` WHERE `tu_like`.`tu_like_id`='".$this->tu_like_id."';"))
			return true;
		
		return false;
		
	}
	
	function getCountByTrackId($id) {
		
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return 0;
		
		if ($result = $mysqli->query("SELECT `tu_like`.* FROM `tu_like` WHERE `tu_like`.`track_id`='".$id."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				return $res['tu_likes'];
				
			}
		}
		
		return 0;
		
	}
	
}

?>