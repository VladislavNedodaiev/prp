<?php

class genre {
	
	var $genre_id;
	var $title;
	
	// set from query result
	function set_from_qresult($res) {
		
		$this->genre_id = $res['genre_id'];
		$this->title = $res['title'];
		
	}
	
	function getById($id) {

		$g = NULL;
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return $g;
		
		if ($result = $mysqli->query("SELECT `genre`.* FROM `genre` WHERE `genre`.`genre_id`='".$id."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$g = new genre;
				$g->set_from_qresult($res);
				return $g;
			}
		}
		
		return $g;
	
	}
	
	function loadById($id) {

		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return mysqli_connect_error();
		
		if ($result = $mysqli->query("SELECT `genre`.* FROM `genre` WHERE `genre`.`genre_id`='".$id."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				$this->set_from_qresult($res);
				return true;
			}
		}
		
		return false;
	
	}
	
	function getCount() {

		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return 0;
		
		if ($result = $mysqli->query("SELECT COUNT(`genre`.`genre_id`) AS genres FROM `genre`;")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				return $res['genres'];
			}
		}
		
		return 0;
	
	}
	
	function getAll() {
		
		$genres = NULL;
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return $genres;
		
		if ($result = $mysqli->query("SELECT `genre`.* FROM `genre`;")) {
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$g = new genre;
				$g->set_from_qresult($res);
				
				$genres[$g->genre_id] = $g;
				
			}
		}
		
		return $genres;
		
	}
	
}

?>