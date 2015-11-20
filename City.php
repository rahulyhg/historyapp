<?php
class City{
	function get(){
		$stmt = DB::getConn()->query("SELECT `id`,`id_state`,`name` FROM city");
		$citys = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $citys;
	}
	function insert($city){
		$conn = DB::getConn();
		$stmt = $conn->prepare("INSERT INTO city (`id`,`id_state`,`name`) VALUES (:id,:id_state,:name)");
		$stmt->bindParam("id",$city->id);
		$stmt->bindParam("id_state",$city->id_state);
		$stmt->bindParam("name",$city->name);
		$stmt->execute();
	}
	function update($city){
		$conn = DB::getConn();
		$stmt = $conn->prepare("UPDATE city SET name = :name WHERE id = :id");
		$stmt->bindParam("id",$city->id);
		$stmt->bindParam("name",$city->name);
		$stmt->execute();
	}
	function delete($city){
		$conn = DB::getConn();
		$stmt = $conn->prepare("DELETE FROM city WHERE id = :id");
		$stmt->bindParam("id",$city->id);
		$stmt->execute();
	}
}