<?php
class Country{
	function get(){
		$stmt = DB::getConn()->query("SELECT `id`,`name` FROM country");
		$countrys = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $countrys;
	}
	function insert($country){
		$conn = DB::getConn();
		$stmt = $conn->prepare("INSERT INTO country (`id`,`name`) VALUES (:id,:name)");
		$stmt->bindParam("id",$country->id);
		$stmt->bindParam("name",$country->name);
		$stmt->execute();
	}
	function update($country){
		$conn = DB::getConn();
		$stmt = $conn->prepare("UPDATE country SET name = :name WHERE id = :id");
		$stmt->bindParam("id",$country->id);
		$stmt->bindParam("name",$country->name);
		$stmt->execute();
	}
	function delete($country){
		$conn = DB::getConn();
		$stmt = $conn->prepare("DELETE FROM country WHERE id = :id");
		$stmt->bindParam("id",$country->id);
		$stmt->execute();
	}
}