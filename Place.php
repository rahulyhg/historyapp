<?php
class Place{
	function get(){
		$stmt = DB::getConn()->query("SELECT `id`,`id_district`,`id_category`,`name`,`description`,`addr`,`location`,`picture_place` FROM place");
		$places = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $places;
	}
	/*function insert($place){
		$conn = DB::getConn();
		$stmt = $conn->prepare("INSERT INTO place (`id`,`id_district`,`id_category`,`name`,`description`,`addr`,`location`,`picture_place`) VALUES (:id,:id_district,:id_category,:name,:description,:addr,:location,:picture_place)");
		$stmt->bindParam("id",$place->id);
		$stmt->bindParam("id_district",$place->id_district);
		$stmt->bindParam("id_category",$place->id_category);
		$stmt->bindParam("name",$place->name);
		$stmt->bindParam("description",$place->description);
		$stmt->bindParam("addr",$place->addr);
		$stmt->bindParam("location",$place->location);
		$stmt->bindParam("picture_place",$place->picture_place);
		$stmt->execute();
	}*/
	function insert($place){
		$conn = DB::getConn();

		$fileString = $place->picture;
		$ext = $place->ext;
		$now = date("D M j G:i:s T Y");
		$filename = md5($place->name.$now);
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

		$picture_place = $filename;

		$stmt = $conn->prepare("INSERT INTO place 
			(`id`,`id_district`,`id_category`,`name`,`description`,`addr`,`location`,`picture_place`) 
			VALUES (NULL,
					'$place->id_district',
					'$place->id_category',
					'$place->name',
					'$place->description',
					'$place->addr',
					'$place->location',
					'$picture_place')");
		
		$stmt->execute();
	}
	function update($place){
		$conn = DB::getConn();
		$stmt = $conn->prepare("UPDATE place SET name = :name,description = :description,addr = :addr,location = :location,picture_place = :picture_place WHERE id = :id");
		$stmt->bindParam("id",$place->id);
		$stmt->bindParam("name",$place->name);
		$stmt->bindParam("description",$place->description);
		$stmt->bindParam("addr",$place->addr);
		$stmt->bindParam("location",$place->location);
		$stmt->bindParam("picture_place",$place->picture_place);
		$stmt->execute();
	}
	function delete($place){
		$conn = DB::getConn();
		$stmt = $conn->prepare("DELETE FROM place WHERE id = :id");
		$stmt->bindParam("id",$place->id);
		$stmt->execute();
	}
	function getbycat($param){
		//$conn = DB::getConn();
		$stmt = DB::getConn()->query("select place.*
        , district.name as name_district
        , category.name as name_category
        , state.id as id_state
        , state.name as name_state
        , city.id as id_city
        , city.name as name_city
        , country.id as id_country
        , country.name as name_country
        from place join district on (place.id_district = district.id) 
					join city on (district.id_city = city.id)
                    join state on (city.id_state = state.id)
                    join country on (state.id_country = country.id)
                    join category on (place.id_category = category.id)
		where place.id_category = $param->id_cat");
		
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}
	
	function find($param){
		//$conn = DB::getConn();
		$stmt = DB::getConn()->query("select place.*
        , district.name as name_district
        , category.name as name_category
        , state.id as id_state
        , state.name as name_state
        , city.id as id_city
        , city.name as name_city
        , country.id as id_country
        , country.name as name_country
        from place join district on (place.id_district = district.id) 
					join city on (district.id_city = city.id)
                    join state on (city.id_state = state.id)
                    join country on (state.id_country = country.id)
                    join category on (place.id_category = category.id)
		where place.name like '%$param->query%' or
				place.description like '%param->query%' or
                place.addr like '%$param->query%' or
                place.name like '%$param->query%' or
                district.name like '%$param->query%' or
                city.name like '%$param->query%' or
                state.name like '%$param->query%' or
                country.name like '%$param->query%'");
		
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}
}