<?php
class Category{
	function get(){
		$stmt = DB::getConn()->query("SELECT `id`,`name`,`picture` FROM category");
		$categorys = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $categorys;
	}
	function insert($category){
		$conn = DB::getConn();
		$stmt = $conn->prepare("INSERT INTO category (`id`,`name`,`picture`) VALUES (:id,:name,:picture)");
		$stmt->bindParam("id",$category->id);
		$stmt->bindParam("name",$category->name);
		$stmt->bindParam("picture",$category->picture);
		$stmt->execute();
	}
	function update($category){
		$conn = DB::getConn();
		$stmt = $conn->prepare("UPDATE category SET name = :name,picture = :picture WHERE id = :id");
		$stmt->bindParam("id",$category->id);
		$stmt->bindParam("name",$category->name);
		$stmt->bindParam("picture",$category->picture);
		$stmt->execute();
	}
	function delete($category){
		$conn = DB::getConn();
		$stmt = $conn->prepare("DELETE FROM category WHERE id = :id");
		$stmt->bindParam("id",$category->id);
		$stmt->execute();
	}
}