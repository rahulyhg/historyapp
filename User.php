<?php
class User{
	function get(){
		$stmt = DB::getConn()->query("SELECT `id`,`name`,`email`,`passwd`,`picture_profile` FROM user");
		$users = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $users;
	}
	function insert($user){
		$conn = DB::getConn();
		$stmt = $conn->prepare("INSERT INTO user (`id`,`name`,`email`,`passwd`,`picture_profile`) VALUES (:id,:name,:email,:passwd,:picture_profile)");
		$stmt->bindParam("id",$user->id);
		$stmt->bindParam("name",$user->name);
		$stmt->bindParam("email",$user->email);
		$stmt->bindParam("passwd",$user->passwd);
		$stmt->bindParam("picture_profile",$user->picture_profile);
		$stmt->execute();
	}
	function update($user){
		$conn = DB::getConn();
		$stmt = $conn->prepare("UPDATE user SET name = :name,email = :email,passwd = :passwd,picture_profile = :picture_profile WHERE id = :id");
		$stmt->bindParam("id",$user->id);
		$stmt->bindParam("name",$user->name);
		$stmt->bindParam("email",$user->email);
		$stmt->bindParam("passwd",$user->passwd);
		$stmt->bindParam("picture_profile",$user->picture_profile);
		$stmt->execute();
	}
	function delete($user){
		$conn = DB::getConn();
		$stmt = $conn->prepare("DELETE FROM user WHERE id = :id");
		$stmt->bindParam("id",$user->id);
		$stmt->execute();
	}
}