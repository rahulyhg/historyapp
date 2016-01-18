<?php
class User{
	function get(){
		$stmt = DB::getConn()->query("SELECT `id`,`name`,`email`,`passwd`,`picture_profile` FROM user");
		$users = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $users;
	}
	/*function insert($user){
		$conn = DB::getConn();
		$stmt = $conn->prepare("INSERT INTO user (`id`,`name`,`email`,`passwd`,`picture_profile`) VALUES (:id,:name,:email,:passwd,:picture_profile)");
		$stmt->bindParam("id",$user->id);
		$stmt->bindParam("name",$user->name);
		$stmt->bindParam("email",$user->email);
		$stmt->bindParam("passwd",$user->passwd);
		$stmt->bindParam("picture_profile",$user->picture_profile);
		$stmt->execute();
	}*/
	/*function update($user){
		$conn = DB::getConn();
		$stmt = $conn->prepare("UPDATE user SET name = :name,email = :email,passwd = :passwd,picture_profile = :picture_profile WHERE id = :id");
		$stmt->bindParam("id",$user->id);
		$stmt->bindParam("name",$user->name);
		$stmt->bindParam("email",$user->email);
		$stmt->bindParam("passwd",$user->passwd);
		$stmt->bindParam("picture_profile",$user->picture_profile);
		$stmt->execute();
	}*/
	function update($user){
		$conn = DB::getConn();
		$stmt = $conn->prepare("UPDATE user SET name = '$user->name', passwd = '$user->passwd' WHERE id = $user->id");
		$stmt->execute();

		$array_response = array();
		$stmt = DB::getConn()->query("SELECT id,name,email,picture_profile,passwd  FROM user WHERE id = '$user->id'");
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
		$array_response["user"] = $user;

		return $array_response;
	}
	/*function delete($user){
		$conn = DB::getConn();
		$stmt = $conn->prepare("DELETE FROM user WHERE id = :id");
		$stmt->bindParam("id",$user->id);
		$stmt->execute();
	}*/
	function delete($user){
		$conn = DB::getConn();
		$stmt = $conn->prepare("DELETE FROM user WHERE id = $user->id");
		$stmt->execute();
	}

	function login($user){
		$array_response = array();
		$stmt = DB::getConn()->query("SELECT id,name,email,picture_profile,passwd FROM user WHERE email = '$user->email' and passwd = '$user->passwd'");
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
		$array_response["user"] = $user;

		return $array_response;
	}

	function insert($user){
		$conn = DB::getConn();
		$stmt = $conn->prepare("INSERT INTO user (`id`,`name`,`email`,`passwd`,`picture_profile`,`date_time`) VALUES (NULL,'$user->name','$user->email','$user->passwd','$user->picture_profile',NULL)");
		$stmt->execute();

		$array_response = array();
		$stmt = DB::getConn()->query("SELECT id,name,email,picture_profile,passwd FROM user WHERE email = '$user->email' and passwd = '$user->passwd'");
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
		$array_response["user"] = $user;

		return $array_response;
	}
}