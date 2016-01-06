<?php
class Commentary{
	function get(){
		$stmt = DB::getConn()->query("SELECT `id`,`id_user`,`id_place`,`comment_text`,`date_time` FROM commentary");
		$commentarys = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $commentarys;
	}
	/*function insert($commentary){
		$conn = DB::getConn();
		$stmt = $conn->prepare("INSERT INTO commentary (`id`,`id_user`,`id_place`,`comment_text`) VALUES (:id,:id_user,:id_place,:comment_text)");
		$stmt->bindParam("id",$commentary->id);
		$stmt->bindParam("id_user",$commentary->id_user);
		$stmt->bindParam("id_place",$commentary->id_place);
		$stmt->bindParam("comment_text",$commentary->comment_text);
		$stmt->execute();
	}*/

	function insert($commentary){
		$conn = DB::getConn();
		$stmt = $conn->prepare("INSERT INTO commentary 
			(`id_user`,`id_place`,`comment_text`) 
			VALUES ('$commentary->id_user',
					'$commentary->id_place',
					'$commentary->comment_text')");
		return $stmt->execute();
	}

	

	function update($commentary){
		$conn = DB::getConn();
		$stmt = $conn->prepare("UPDATE commentary SET comment_text = :comment_text WHERE id = :id");
		$stmt->bindParam("id",$commentary->id);
		$stmt->bindParam("comment_text",$commentary->comment_text);
		$stmt->execute();
	}
	/*function delete($commentary){
		$conn = DB::getConn();
		$stmt = $conn->prepare("DELETE FROM commentary WHERE id = :id");
		$stmt->bindParam("id",$commentary->id);
		$stmt->execute();
	}*/

	function delete($commentary){
		$conn = DB::getConn();
		$stmt = $conn->prepare("DELETE FROM commentary WHERE id = $commentary->id_commentary");
		//$stmt->bindParam("id",$commentary->id);
		$stmt->execute();
	}

	function list_($commentary){
		$stmt = DB::getConn()->query("SELECT `id`,`id_user`,`id_place`,`comment_text`,`date_time` FROM commentary WHERE id_place = '$commentary->id_place'");
		$commentarys = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $commentarys;
	}

	function listall($commentary){
		$array_response = array();
		$stmt = DB::getConn()->query("SELECT `id`,`id_user`,`id_place`,`comment_text`,`date_time` FROM commentary WHERE id_place = '$commentary->id_place' ORDER BY date_time DESC");
		$temp_commentary = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$commentaries = array();

		foreach ($temp_commentary as $commentary) {
			$idUser = $commentary["id_user"];
			$idPlace = $commentary["id_place"];
			$stmt = DB::getConn()->query("SELECT id,name,email,picture_profile,date_time FROM user WHERE id = '$idUser'");
			$user = $stmt->fetch(PDO::FETCH_ASSOC);
			$commentary["user"] = $user;

			$stmt = DB::getConn()->query("SELECT rating.* FROM rating WHERE id_user = '$idUser' and id_place = '$idPlace'");
			$rating = $stmt->fetch(PDO::FETCH_ASSOC);
			$commentary["rating"] = $rating;

			array_push($commentaries, $commentary);
		}

		$array_response["commentaries"] = $commentaries;

		return $array_response;
	}
}