<?php
class DB {
	private static $conn;
	public static function getConn(){
		if(!isset(self::$conn)){
			self::$conn = new PDO('mysql:host=localhost;dbname=history_app;charset=utf8','root','',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",PDO::MYSQL_ATTR_INIT_COMMAND => "SET SQL_MODE=ANSI_QUOTES"));
		}
		return self::$conn;
	}
	public static  function disconnect(){
		if(isset(self::$conn)){
			self::$conn->close();
		}
	}
}
