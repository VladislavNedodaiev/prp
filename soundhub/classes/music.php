<?php

class account {
	
	var $user_id;
	var $login;
	var $password;
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
		$this->password = $res['password'];
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
		
		if ($result = $mysqli->query("SELECT `user`.* FROM `user` WHERE (`user`.`login`='".$login_email."' OR `user`.`email`='".$login_email."') AND `user`.`password`='".password_hash($password, PASSWORD_BCRYPT)."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				$this->set_from_qresult($res);
				return true;
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
		
		if ($mysqli->query("INSERT INTO `account`(`login`, `password`, `email`)".
						   "VALUES (".
						   "'".$login."', ".
						   "'".$email."', ".
						   "'".password_hash($password, PASSWORD_BCRYPT)."');")) 
								return true;
		
		
		
		return false;
		
	}
	
	// reloads the account from database
	function reload_db() {

		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return mysqli_connect_error();
		
		if ($result = $mysqli->query("SELECT `user`.* FROM `user` WHERE `user`.`login`='".$this->user_id."';")) {
			if ($res = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				$this->set_from_qresult($res);
				return true;
			}
		}
		
		return false;
	
	}
	
	// updates the database 
	function update_db() {

		$mysqli = (include "../scripts/connectdb.php");
		
		if ($mysqli->connect_errno)
			return mysqli_connect_error();
		
		if ($mysqli->query("UPDATE `user` SET "
						   ."`photo`='".$this->photo."', "
						   ."`description`='".$this->description."', "
						   ."`phone`='".$this->phone."', "
						   ."`money`='".$this->money."', "
						   ."`premium`='".$this->premium."', "
						   ."`premium_date`=STR_TO_DATE('".$this->premium_date."', '%Y-%m-%d %H:%i:%s'), "
						   ."`premium_duration`='".$this->premium_duration."' "
						   ."WHERE `user_id`=".$this->user_id.";"))
			return true;
		
		return false;
		
	}
	
}

?>