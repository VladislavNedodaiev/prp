<?php

class subscription {
	
	var $subscription_id;
	var $user_from_id;
	var $user_to_id;
	
	// set from query result
	function set_from_qresult($res) {
		
		$this->subscription_id = $res['subscription_id'];
		$this->user_from_id = $res['user_from_id'];
		$this->user_to_id = $res['user_to_id'];
		
	}
	
	function getById ($id) {
		
		$sscribtion = NULL;
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return $sscribtion;
		
		if ($result = $mysqli->query("SELECT `subscription`.* FROM `subscription` WHERE `subscription`.`subscription_id`='".$id."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

				$sscribtion = new subscription;
				$sscribtion ->set_from_qresult($res);
				return $sscribtion;
				
			}
		}
		
		return $sscribtion;
		
	}
	
	function getByFromTo($idFROM, $idTO) {
		
		$sscribtion = NULL;
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return $sscribtion;
		
		if ($result = $mysqli->query("SELECT `subscription`.* FROM `subscription` WHERE `subscription`.`user_from_id`='".$idFROM."' AND `subscription`.`user_to_id`='".$idTO."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

				$sscribtion = new subscription;
				$sscribtion ->set_from_qresult($res);
				return $sscribtion;
				
			}
		}
		
		return $sscribtion;
		
	}
	
	function loadById ($id) {
		
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return mysqli_connect_error();
		
		if ($result = $mysqli->query("SELECT `subscription`.* FROM `subscription` WHERE `subscription`.`subscription_id`='".$id."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

				$this->set_from_qresult($res);
				return true;
				
			}
		}
		
		return false;
		
	}
	
	function loadByFromTo ($idFROM, $idTO) {
		
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return mysqli_connect_error();
		
		if ($result = $mysqli->query("SELECT `subscription`.* FROM `subscription` WHERE `subscription`.`user_from_id`='".$idFROM."' AND `subscription`.`user_to_id`='".$idTO."';")) {
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
		
		if ($this->getByFromTo($this->$user_from_id, $this->$user_to_id))
			return false;
		
		if ($mysqli->query("INSERT INTO `subscription`(`user_from_id`, `user_to_id`) ".
						   "VALUES (".
						   "'".$this->user_from_id."', ".
						   "'".$this->user_to_id."');"))  {
		
			return true;
		
		}

		return false;
		
	}
	
	function remove() {
		
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return mysqli_connect_error();
		
		if ($mysqli->query("DELETE FROM `subscription` WHERE `subscription`.`subscription_id`='".$this->subscription_id."'"))
			return true;
		
		return false;
		
	}
	
	function getByFromId($id) {
		
		$sscriptions = NULL;
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return $sscriptions;
		
		if ($result = $mysqli->query("SELECT `subscription`.* FROM `subscription` WHERE `subscription`.`user_from_id`='".$id."';")) {
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$s = new subscription;
				$s->set_from_qresult($res);
				
				$sscriptions[$s->subscription_id] = $s;
				
			}
		}
		
		return $sscriptions;
		
	}
	
	function getByToId($id) {
		
		$sscriptions = NULL;
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return $sscriptions;
		
		if ($result = $mysqli->query("SELECT `subscription`.* FROM `subscription` WHERE `subscription`.`user_to_id`='".$id."';")) {
			while ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$s = new subscription;
				$s->set_from_qresult($res);
				
				$sscriptions[$s->subscription_id] = $s;
				
			}
		}
		
		return $sscriptions;
		
	}
	
}

?>