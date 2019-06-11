<?php

class user {
	
	var $user_id;
	var $login;
	var $photo;
	var $description;
	var $phone;
	var $register_date;
	var $email;
	var $money;
	var $premium;
	var $premium_date;
	var $premium_duration;
	
	// set from query result
	function set_from_qresult($res) {
		
		$this->user_id = $res['user_id'];
		$this->login = $res['login'];
		$this->photo = $res['photo'];
		$this->description = $res['description'];
		$this->phone = $res['phone'];
		$this->register_date = $res['register_date'];
		$this->email = $res['email'];
		$this->money = $res['money'];
		$this->premium = $res['premium'];
		$this->premium_date = $res['premium_date'];
		$this->premium_duration = $res['premium_duration'];
		
	}
	
	function login ($login_email, $password) {
		
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return mysqli_connect_error();
		
		if ($result = $mysqli->query("SELECT `user`.* FROM `user` WHERE `user`.`login`='".$login_email."' OR `user`.`email`='".$login_email."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				if (password_verify($password, $res['password'])) {
				
					$this->set_from_qresult($res);
					return true;
				
				}
				
			}
		}
		
		return false;
		
	}
	
	function register ($login, $email, $password) {
		
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return mysqli_connect_error();
		
		if ($result = $mysqli->query("SELECT `user`.* FROM `user` WHERE `user`.`login`='".$login."' OR `user`.`email`='".$email."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				if ($res['login']==$login)
					return $login;
				else
					return $email;
			}
		}
		
		if ($mysqli->query("INSERT INTO `user`(`login`, `email`, `password`)".
						   "VALUES (".
						   "'".$login."', ".
						   "'".$email."', ".
						   "'".password_hash($password, PASSWORD_BCRYPT)."');"))  {
			
			return true;
		
		}

		return false;
		
	}
	
	// reloads the account from database
	function getById($id) {

		$usr = NULL;
		
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return $usr;
		
		if ($result = $mysqli->query("SELECT `user`.* FROM `user` WHERE `user`.`user_id`='".$id."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				
				$usr = new user;
				$usr->set_from_qresult($res);
				return $usr;
				
			}
		}
		
		return $usr;
	
	}
	
	function loadById($id) {

		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return mysqli_connect_error();
		
		if ($result = $mysqli->query("SELECT `user`.* FROM `user` WHERE `user`.`user_id`='".$id."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				$this->set_from_qresult($res);
				return true;
			}
		}
		
		return false;
	
	}
	
	// updates the database 
	function update() {

		$mysqli = (include "../scripts/connectdb.php");
		
		return "UPDATE `user` SET "
						   ."`photo`='".$this->photo."', "
						   ."`description`='".$this->description."', "
						   ."`phone`='".$this->phone."', "
						   ."`money`='".$this->money."' "
						   ."WHERE `user_id`=".$this->user_id.";";
		
		if ($mysqli->connect_errno)
			return mysqli_connect_error();
		
		if ($mysqli->query("UPDATE `user` SET "
						   ."`photo`='".$this->photo."', "
						   ."`description`='".$this->description."', "
						   ."`phone`='".$this->phone."', "
						   ."`money`='".$this->money."' "
						   ."WHERE `user_id`=".$this->user_id.";"))
			return true;
		
		return false;
		
	}
	
	function getTotalLikes() {
		
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return 0;
		
		if ($result = $mysqli->query("SELECT COUNT(`tu_like`.`tu_like_id`) AS likes FROM `tu_like`, `track` WHERE `tu_like`.`track_id`=`track`.`track_id` AND `track`.`user_id`='".$this->user_id."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				return $res['likes'];
			}
		}
		
		return 0;
		
	}
	
	function getTotalFollowers() {
		
		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return 0;
		
		if ($result = $mysqli->query("SELECT COUNT(`subscriber`.`subscriber_id`) AS subscribers FROM `subscriber`, `subscription` WHERE `subscriber`.`subscriber_id`=`subscription`.`subscriber_id` AND `subscription`.`user_id`='".$this->user_id."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				return $res['subscribers'];
			}
		}
		
		return 0;
		
	}
	
}

?>