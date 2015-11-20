<?php
class State{
	function get(){
		$stmt = DB::getConn()->query("SELECT `id`,`id_country`,`name` FROM state");
		$states = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $states;
	}
	function insert($state){
		$conn = DB::getConn();
		$stmt = $conn->prepare("INSERT INTO state (`id`,`id_country`,`name`) VALUES (:id,:id_country,:name)");
		$stmt->bindParam("id",$state->id);
		$stmt->bindParam("id_country",$state->id_country);
		$stmt->bindParam("name",$state->name);
		$stmt->execute();
	}
	function update($state){
		$conn = DB::getConn();
		$stmt = $conn->prepare("UPDATE state SET name = :name WHERE id = :id");
		$stmt->bindParam("id",$state->id);
		$stmt->bindParam("name",$state->name);
		$stmt->execute();
	}
	function delete($state){
		$conn = DB::getConn();
		$stmt = $conn->prepare("DELETE FROM state WHERE id = :id");
		$stmt->bindParam("id",$state->id);
		$stmt->execute();
	}
}