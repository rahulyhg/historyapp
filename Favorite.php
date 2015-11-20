<?php
class Favorite{
	function get(){
		$stmt = DB::getConn()->query("SELECT `id`,`id_user`,`id_place` FROM favorite");
		$favorites = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $favorites;
	}
	function insert($favorite){
		$conn = DB::getConn();
		$stmt = $conn->prepare("INSERT INTO favorite (`id`,`id_user`,`id_place`) VALUES (:id,:id_user,:id_place)");
		$stmt->bindParam("id",$favorite->id);
		$stmt->bindParam("id_user",$favorite->id_user);
		$stmt->bindParam("id_place",$favorite->id_place);
		$stmt->execute();
	}

	function delete($favorite){
		$conn = DB::getConn();
		$stmt = $conn->prepare("DELETE FROM favorite WHERE id = :id");
		$stmt->bindParam("id",$favorite->id);
		$stmt->execute();
	}
}