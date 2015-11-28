<?php
class Rating{
	/*function get(){
		$stmt = DB::getConn()->query("SELECT `id`,`id_user`,`id_place`,`rating_value`,`rating_text` FROM rating");
		$ratings = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $ratings;
	}*/
	function insert($rating){
		$conn = DB::getConn();
		$stmt = $conn->prepare("INSERT INTO rating (`id`,`id_user`,`id_place`,`rating_value`,`rating_text`) VALUES (:id,:id_user,:id_place,:rating_value,:rating_text)");
		$stmt->bindParam("id",$rating->id);
		$stmt->bindParam("id_user",$rating->id_user);
		$stmt->bindParam("id_place",$rating->id_place);
		$stmt->bindParam("rating_value",$rating->rating_value);
		$stmt->bindParam("ratinh_text",$rating->ratinh_text);
		$stmt->execute();
	}
	/*function update($rating){
		$conn = DB::getConn();
		$stmt = $conn->prepare("UPDATE rating SET rating_value = :rating_value,rating_value = :rating_text WHERE id = :id");
		$stmt->bindParam("id",$rating->id);
		$stmt->bindParam("rating_value",$rating->rating_value);
		$stmt->bindParam("ratinh_text",$rating->ratinh_text);
		$stmt->execute();
	}*/
	function delete($rating){
		$conn = DB::getConn();
		$stmt = $conn->prepare("DELETE FROM rating WHERE id = :id");
		$stmt->bindParam("id",$rating->id);
		$stmt->execute();
	}

	function get($rating){
		$conn = DB::getConn();
		$stmt = DB::getConn()->query("SELECT `id`,`id_user`,`id_place`,`rating_value`,`rating_text` FROM rating WHERE id_user = '$rating->id_user' and id_place = '$rating->id_place'");
		//$stmt->bindParam("id",$favorite->id);
		return $stmt->fetch(PDO::FETCH_OBJ);//retorna apenas um
	}

	function set($rating){
		$conn = DB::getConn();
		$stmt = $conn->prepare("INSERT INTO rating (`id`,`id_user`,`id_place`,`rating_value`,`rating_text`) VALUES (null,'$rating->id_user','$rating->id_place','$rating->value','$rating->text')");
		//$stmt->bindParam("id",$favorite->id);
		return $stmt->execute();
	}

	function update($rating){
		$conn = DB::getConn();
		$stmt = $conn->prepare("UPDATE rating SET rating_value = '$rating->value',rating_text = '$rating->text' WHERE id_user = '$rating->id_user' and id_place = '$rating->id_place'");
		//$stmt->bindParam("id",$favorite->id);
		return $stmt->execute();
	}
}