<?php
class Picture{
	function get(){
		$stmt = DB::getConn()->query("SELECT `id`,`id_place`,`file_string`,`picture_text` FROM picture");
		$pictures = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $pictures;
	}
	function insert($picture){
		$conn = DB::getConn();
		$stmt = $conn->prepare("INSERT INTO picture (`id`,`id_place`,`file_string`,`picture_text`) VALUES (:id,:id_place,:file_string,:picture_text)");
		$stmt->bindParam("id",$picture->id);
		$stmt->bindParam("id_place",$picture->id_place);
		$stmt->bindParam("file_string",$picture->file_string);
		$stmt->bindParam("picture_text",$picture->picture_text);
		$stmt->execute();
	}
	function update($picture){
		$conn = DB::getConn();
		$stmt = $conn->prepare("UPDATE picture SET file_string = :file_string,picture_text = :picture_text WHERE id = :id");
		$stmt->bindParam("id",$picture->id);
		$stmt->bindParam("file_string",$picture->file_string);
		$stmt->bindParam("picture_text",$picture->picture_text);
		$stmt->execute();
	}
	function delete($picture){
		$conn = DB::getConn();
		$stmt = $conn->prepare("DELETE FROM picture WHERE id = :id");
		$stmt->bindParam("id",$picture->id);
		$stmt->execute();
	}
}