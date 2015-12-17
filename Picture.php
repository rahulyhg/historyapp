<?php
class Picture{
	function get(){
		$stmt = DB::getConn()->query("SELECT `id`,`id_place`,`file_string`,`picture_text` FROM picture");
		$pictures = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $pictures;
	}
	/*function insert($picture){
		$conn = DB::getConn();
		$stmt = $conn->prepare("INSERT INTO picture (`id`,`id_place`,`file_string`,`picture_text`) VALUES (:id,:id_place,:file_string,:picture_text)");
		$stmt->bindParam("id",$picture->id);
		$stmt->bindParam("id_place",$picture->id_place);
		$stmt->bindParam("file_string",$picture->file_string);
		$stmt->bindParam("picture_text",$picture->picture_text);
		$stmt->execute();
	}*/
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
	function getByPlace($param){
		//$conn = DB::getConn();
		$stmt = DB::getConn()->query("select *
        from picture 
		where id_place = $param->id_place");
		
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	function insert($picture){
		$conn = DB::getConn();

		$fileString = $picture->file_string;
		$ext = $picture->ext;
		$now = date("D M j G:i:s T Y");
		$filename = md5($picture->place_name.$now);
		$filename = $filename.".".$ext ;

		$binary = base64_decode($fileString);
	    header('Content-Type: bitmap; charset=utf-8');

	    $aliasRootFolder = "/var/www/html/historyapp/web";

	    $file = fopen($aliasRootFolder.'/images/__w-200-400-600-800-1000__/' . $filename, 'wb');
	    // Create File
	    fwrite($file, $binary);
	    fclose($file);

	    $file = fopen($aliasRootFolder.'/images/w200/' . $filename, 'wb');
	    // Create File
	    fwrite($file, $binary);
	    fclose($file);

	    $file = fopen($aliasRootFolder.'/images/w400/' . $filename, 'wb');
	    // Create File
	    fwrite($file, $binary);
	    fclose($file);

	    $file = fopen($aliasRootFolder.'/images/w600/' . $filename, 'wb');
	    // Create File
	    fwrite($file, $binary);
	    fclose($file);

	    $file = fopen($aliasRootFolder.'/images/w800/' . $filename, 'wb');
	    // Create File
	    fwrite($file, $binary);
	    fclose($file);

	    $file = fopen($aliasRootFolder.'/images/w1000/' . $filename, 'wb');
	    // Create File
	    fwrite($file, $binary);
	    fclose($file);

	    $picture_name = $filename;

		$stmt = $conn->prepare("INSERT INTO picture (`id`,`id_place`,`file_string`,`picture_text`) VALUES (NULL,'$picture->id_place','$picture_name','$picture->text')");
		$stmt->execute();
	}
}