<?php
class District{
	function get(){
		$stmt = DB::getConn()->query("SELECT `id`,`id_city`,`name` FROM district");
		$districts = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $districts;
	}
	function insert($district){
		$conn = DB::getConn();
		$stmt = $conn->prepare("INSERT INTO district (`id`,`id_city`,`name`) VALUES (:id,:id_city,:name)");
		$stmt->bindParam("id",$district->id);
		$stmt->bindParam("id_city",$district->id_city);
		$stmt->bindParam("name",$district->name);
		$stmt->execute();
	}
	function update($district){
		$conn = DB::getConn();
		$stmt = $conn->prepare("UPDATE district SET name = :name WHERE id = :id");
		$stmt->bindParam("id",$district->id);
		$stmt->bindParam("name",$district->name);
		$stmt->execute();
	}
	function delete($district){
		$conn = DB::getConn();
		$stmt = $conn->prepare("DELETE FROM district WHERE id = :id");
		$stmt->bindParam("id",$district->id);
		$stmt->execute();
	}
}