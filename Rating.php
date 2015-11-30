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

	function list_($rating){
		$stmt = DB::getConn()->query("SELECT rating.id as id_rating,
											 rating.id_place as id_place,
											 rating.rating_value as rating_value,
											 rating.rating_text as rating_text,
											 user.id as id_user,
											 user.name as name_user,
											 user.email as email_user,
											 date_format(rating.date_time,'%d/%m/%Y') as date_time
											 FROM rating join user on(user.id = rating.id_user) WHERE id_place = '$rating->id_place'");
		$ratings = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $ratings;
	}
}