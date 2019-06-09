<?php

if (!isset($_SESSION))
	session_start();

$host = "remotemysql.com:3306";
$user = "rin2sj0aBG";
$pswd = "H6qAPgq72i";
$db = "rin2sj0aBG";

$mysqli = new mysqli($host, $user, $pswd, $db);
$mysqli->set_charset('utf8');

return $mysqli;

?>