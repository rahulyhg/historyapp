<?php
class Commentary{
	function get(){
		$stmt = DB::getConn()->query("SELECT `id`,`id_user`,`id_place`,`comment_text` FROM commentary");
		$commentarys = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $commentarys;
	}
	function insert($commentary){
		$conn = DB::getConn();
		$stmt = $conn->prepare("INSERT INTO commentary (`id`,`id_user`,`id_place`,`comment_text`) VALUES (:id,:id_user,:id_place,:comment_text)");
		$stmt->bindParam("id",$commentary->id);
		$stmt->bindParam("id_user",$commentary->id_user);
		$stmt->bindParam("id_place",$commentary->id_place);
		$stmt->bindParam("comment_text",$commentary->comment_text);
		$stmt->execute();
	}
	function update($commentary){
		$conn = DB::getConn();
		$stmt = $conn->prepare("UPDATE commentary SET comment_text = :comment_text WHERE id = :id");
		$stmt->bindParam("id",$commentary->id);
		$stmt->bindParam("comment_text",$commentary->comment_text);
		$stmt->execute();
	}
	function delete($commentary){
		$conn = DB::getConn();
		$stmt = $conn->prepare("DELETE FROM commentary WHERE id = :id");
		$stmt->bindParam("id",$commentary->id);
		$stmt->execute();
	}

	function list_($commentary){
		$stmt = DB::getConn()->query("SELECT `id`,`id_user`,`id_place`,`comment_text` FROM commentary WHERE id_place = '$commentary->id_place'");
		$commentarys = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $commentarys;
	}
}