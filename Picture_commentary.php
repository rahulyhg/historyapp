<?php
class Picture_commentary{
	function get(){
		$stmt = DB::getConn()->query("SELECT `id`,`id_picture`,`id_user`,`commentary_text` FROM picture_commentary");
		$picture_commentarys = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $picture_commentarys;
	}
	function insert($picture_commentary){
		$conn = DB::getConn();
		$stmt = $conn->prepare("INSERT INTO picture_commentary (`id`,`id_picture`,`id_user`,`commentary_text`) VALUES (:id,:id_picture,:id_user,:commentary_text)");
		$stmt->bindParam("id",$picture_commentary->id);
		$stmt->bindParam("id_picture",$picture_commentary->id_picture);
		$stmt->bindParam("id_user",$picture_commentary->id_user);
		$stmt->bindParam("commentary_text",$picture_commentary->commentary_text);
		$stmt->execute();
	}
	function update($picture_commentary){
		$conn = DB::getConn();
		$stmt = $conn->prepare("UPDATE picture_commentary SET commentary_text = :commentary_text WHERE id = :id");
		$stmt->bindParam("id",$picture_commentary->id);
		$stmt->bindParam("commentary_text",$picture_commentary->commentary_text);
		$stmt->execute();
	}
	function delete($picture_commentary){
		$conn = DB::getConn();
		$stmt = $conn->prepare("DELETE FROM picture_commentary WHERE id = :id");
		$stmt->bindParam("id",$picture_commentary->id);
		$stmt->execute();
	}
}