<?php
class Place{
	function get(){
		$stmt = DB::getConn()->query("SELECT `id`,`id_district`,`id_category`,`name`,`description`,`addr`,`location`,`picture_place` FROM place");
		$places = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $places;
	}
	function insert($place){
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
	
}