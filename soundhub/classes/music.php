<?php

class music {
	
	var $music_id;
	var $track_id;
	var $playlist_id;
	var $post_date;
	
	// set from query result
	function set_from_qresult($res) {
		
		$this->music_id = $res['music_id'];
		$this->track_id = $res['track_id'];
		$this->playlist_id = $res['playlist_id'];
		$this->post_date = $res['post_date'];
		
	}
	
	function getById ($msc_id) {
		
		$m = NULL;
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return $m;
		
		if ($result = $mysqli->query("SELECT `music`.* FROM `music` WHERE `music`.`music_id`='".$msc_id."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$m = new music;
				$m->set_from_qresult($res);
				return $m;			
				
			}
		}
		
		return $m;
		
	}
	
	function loadById ($msc_id) {
		
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return mysqli_connect_error();
		
		if ($result = $mysqli->query("SELECT `music`.* FROM `music` WHERE `music`.`music_id`='".$msc_id."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				$this->set_from_qresult($res);
				return true;				
			}
		}
		
		return false;
		
	}
	
	function getByTPId ($trck_id, $pllst_id) {
		
		$m = NULL;
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return $m;
		
		if ($result = $mysqli->query("SELECT `music`.* FROM `music` WHERE `music`.`track_id`='".$trck_id."' AND `music`.`pllst_id`='".$pllst_id."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$m = new music;
				$m->set_from_qresult($res);
				return $m;
				
			}
		}
		
		return $m;
		
	}
	
	function loadByTPId ($trck_id, $pllst_id) {
		
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return mysqli_connect_error();
		
		if ($result = $mysqli->query("SELECT `music`.* FROM `music` WHERE `music`.`track_id`='".$trck_id."' AND `music`.`pllst_id`='".$pllst_id."';")) {
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
		
		if ($this->getByTPId($this->track_id, $this->playlist_id) != NULL)
			return false;
		
		if ($mysqli->query("INSERT INTO `music`(`track_id`, `playlist_id`) ".
						   "VALUES (".
						   "'".$this->track_id."', ".
						   "'".$this->playlist_id."');"))  {
		
			$this->loadByTPId($this->track_id, $this->playlist_id);
		
			return true;
		
		}

		return false;
		
	}
	
	function remove () {
		
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return mysqli_connect_error();
		
		if ($mysqli->query("DELETE FROM `music` WHERE `music`.`music_id`='".$this->music_id."';"))  {
		
			return true;
		
		}

		return false;
		
	}
	
	function getCountPlaylistTracks() {
		
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return 0;
		
		if ($result = $mysqli->query("SELECT COUNT(`music`.`music_id`) AS genres FROM `music`, `playlist` WHERE `music`.`playlist_id`=`playlist`.`playlist_id`;")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				return $res['genres'];
			}
		}
		
		return 0;
		
	}
	
}

?>