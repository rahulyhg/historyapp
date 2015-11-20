<?php
class Rating{
	function get(){
		$stmt = DB::getConn()->query("SELECT `id`,`id_user`,`id_place`,`rating_value`,`ratinh_text` FROM rating");
		$ratings = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $ratings;
	}
	function insert($rating){
		$conn = DB::getConn();
		$stmt = $conn->prepare("INSERT INTO rating (`id`,`id_user`,`id_place`,`rating_value`,`ratinh_text`) VALUES (:id,:id_user,:id_place,:rating_value,:ratinh_text)");
		$stmt->bindParam("id",$rating->id);
		$stmt->bindParam("id_user",$rating->id_user);
		$stmt->bindParam("id_place",$rating->id_place);
		$stmt->bindParam("rating_value",$rating->rating_value);
		$stmt->bindParam("ratinh_text",$rating->ratinh_text);
		$stmt->execute();
	}
	function update($rating){
		$conn = DB::getConn();
		$stmt = $conn->prepare("UPDATE rating SET rating_value = :rating_value,ratinh_text = :ratinh_text WHERE id = :id");
		$stmt->bindParam("id",$rating->id);
		$stmt->bindParam("rating_value",$rating->rating_value);
		$stmt->bindParam("ratinh_text",$rating->ratinh_text);
		$stmt->execute();
	}
	function delete($rating){
		$conn = DB::getConn();
		$stmt = $conn->prepare("DELETE FROM rating WHERE id = :id");
		$stmt->bindParam("id",$rating->id);
		$stmt->execute();
	}
}