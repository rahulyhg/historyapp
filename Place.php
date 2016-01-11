<?php
class Place{
	function get(){
		$stmt = DB::getConn()->query("SELECT `id`,`id_district`,`id_category`,`name`,`description`,`addr`,`latitude`,`longitude`,`picture_place` FROM place");
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
			(`id`,`id_district`,`id_category`,`name`,`description`,`addr`,`latitude`,`longitude`,`picture_place`) 
			VALUES (NULL,
					'$place->id_district',
					'$place->id_category',
					'$place->name',
					'$place->description',
					'$place->addr',
					'$place->latitude',
					'$place->longitude',
					'$picture_place')");
		
		$stmt->execute();
	}
	function update($place){
		$conn = DB::getConn();
		$stmt = $conn->prepare("UPDATE place SET name = :name,description = :description,addr = :addr,latitude = :latitude,longitude = :longitude,picture_place = :picture_place WHERE id = :id");
		$stmt->bindParam("id",$place->id);
		$stmt->bindParam("name",$place->name);
		$stmt->bindParam("description",$place->description);
		$stmt->bindParam("addr",$place->addr);
		$stmt->bindParam("latitude",$place->latitude);
		$stmt->bindParam("longitude",$place->longitude);
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
		
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	function getbycat2($param){
		$eath_radius_in_km = 6371;
		$user_latitude = $param->user_latitude;
		$user_longitude = $param->user_longitude;
		$radius_in_km = $param->radius;

		//$conn = DB::getConn();
		$array_response = array();
		$stmt = DB::getConn()->query("select place.*, ($eath_radius_in_km *
			        acos(
			            cos(radians($user_latitude)) *
			            cos(radians(latitude)) *
			            cos(radians($user_longitude) - radians(longitude)) +
			            sin(radians($user_latitude)) *
			            sin(radians(latitude))
			        )) AS distance
        from place join category on (place.id_category = category.id)
		where place.id_category = $param->id_cat
		HAVING distance <= $radius_in_km
		ORDER BY distance ASC");
		
		$tempPlaces = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$places = array();
		foreach ($tempPlaces as $place) {
			$idPlace = $place["id"];
			$idDistrict = $place["id_district"];
			$idCategory = $place["id_category"];

			$stmt = DB::getConn()->query("select category.*
				        from category 
						where category.id = $idCategory");

			$category = $stmt->fetch(PDO::FETCH_ASSOC);
			
			$stmt = DB::getConn()->query("select district.*
				        from district 
						where district.id = $idDistrict");

			$district = $stmt->fetch(PDO::FETCH_ASSOC);
			$idCity = $district["id_city"];

			$stmt = DB::getConn()->query("select city.*
				        from city 
						where city.id = $idCity");

			$city = $stmt->fetch(PDO::FETCH_ASSOC);
			$idState = $city["id_state"];

			$stmt = DB::getConn()->query("select state.*
				        from state 
						where state.id = $idState");

			$state = $stmt->fetch(PDO::FETCH_ASSOC);
			$idCountry = $state["id_country"];

			$stmt = DB::getConn()->query("select country.*
				        from country 
						where country.id = $idCountry");

			$country = $stmt->fetch(PDO::FETCH_ASSOC);

			$stmt = DB::getConn()->query("select rating.*
				        from rating 
						where rating.id_place = $idPlace");

			$temp_ratings = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$ratings = array();
			foreach ($temp_ratings as $rating) {
				$idUser = $rating["id_user"];
				$stmt = DB::getConn()->query("select user.*
				        from user 
						where user.id = $idUser");

				$user = $stmt->fetch(PDO::FETCH_ASSOC);

				$rating["user"]=$user;
				array_push($ratings, $rating);
			}

			$state["country"] = $country;
			$city["state"] = $state;
			$district["city"] = $city;
			$place["district"] = $district;
			$place["category"] = $category;
			if(sizeof($ratings)>0){
				$place["ratings"] = $ratings;	
			}
			
			array_push($places, $place);
		}
		$array_response["places"] = $places;

		return $array_response;
	}

	function getall($param){
		$eath_radius_in_km = 6371;
		$user_latitude = $param->user_latitude;
		$user_longitude = $param->user_longitude;
		$radius_in_km = $param->radius;

		//$conn = DB::getConn();
		$array_response = array();
		$stmt = DB::getConn()->query("select place.*, ($eath_radius_in_km *
			        acos(
			            cos(radians($user_latitude)) *
			            cos(radians(latitude)) *
			            cos(radians($user_longitude) - radians(longitude)) +
			            sin(radians($user_latitude)) *
			            sin(radians(latitude))
			        )) AS distance
        from place join category on (place.id_category = category.id)
		HAVING distance <= $radius_in_km
		ORDER BY distance ASC");
		
		$tempPlaces = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$places = array();
		foreach ($tempPlaces as $place) {
			$idPlace = $place["id"];
			$idDistrict = $place["id_district"];
			$idCategory = $place["id_category"];

			$stmt = DB::getConn()->query("select category.*
				        from category 
						where category.id = $idCategory");

			$category = $stmt->fetch(PDO::FETCH_ASSOC);
			
			$stmt = DB::getConn()->query("select district.*
				        from district 
						where district.id = $idDistrict");

			$district = $stmt->fetch(PDO::FETCH_ASSOC);
			$idCity = $district["id_city"];

			$stmt = DB::getConn()->query("select city.*
				        from city 
						where city.id = $idCity");

			$city = $stmt->fetch(PDO::FETCH_ASSOC);
			$idState = $city["id_state"];

			$stmt = DB::getConn()->query("select state.*
				        from state 
						where state.id = $idState");

			$state = $stmt->fetch(PDO::FETCH_ASSOC);
			$idCountry = $state["id_country"];

			$stmt = DB::getConn()->query("select country.*
				        from country 
						where country.id = $idCountry");

			$country = $stmt->fetch(PDO::FETCH_ASSOC);

			$stmt = DB::getConn()->query("select rating.*
				        from rating 
						where rating.id_place = $idPlace");

			$temp_ratings = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$ratings = array();
			foreach ($temp_ratings as $rating) {
				$idUser = $rating["id_user"];
				$stmt = DB::getConn()->query("select user.*
				        from user 
						where user.id = $idUser");

				$user = $stmt->fetchAll(PDO::FETCH_ASSOC);

				$rating["user"]=$user;
				array_push($ratings, $rating);
			}

			$state["country"] = $country;
			$city["state"] = $state;
			$district["city"] = $city;
			$place["district"] = $district;
			$place["category"] = $category;
			if(sizeof($ratings)>0){
				$place["ratings"] = $ratings;	
			}

			array_push($places, $place);
		}
		$array_response["places"] = $places;

		return $array_response;
	}
	
	/*function find($param){
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
	}*/

	function find($param){
		$eath_radius_in_km = 6371;
		$user_latitude = $param->user_latitude;
		$user_longitude = $param->user_longitude;
		$radius_in_km = $param->radius;

		//$conn = DB::getConn();
		$array_response = array();
		$stmt = DB::getConn()->query("select place.*, ($eath_radius_in_km *
			        acos(
			            cos(radians($user_latitude)) *
			            cos(radians(latitude)) *
			            cos(radians($user_longitude) - radians(longitude)) +
			            sin(radians($user_latitude)) *
			            sin(radians(LATITUDE))
			        )) AS distance
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
                country.name like '%$param->query%'
		HAVING distance <= $radius_in_km
		ORDER BY distance ASC");
		
		$tempPlaces = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$places = array();
		foreach ($tempPlaces as $place) {
			$idPlace = $place["id"];
			$idDistrict = $place["id_district"];
			$idCategory = $place["id_category"];

			$stmt = DB::getConn()->query("select category.*
				        from category 
						where category.id = $idCategory");

			$category = $stmt->fetch(PDO::FETCH_ASSOC);
			
			$stmt = DB::getConn()->query("select district.*
				        from district 
						where district.id = $idDistrict");

			$district = $stmt->fetch(PDO::FETCH_ASSOC);
			$idCity = $district["id_city"];

			$stmt = DB::getConn()->query("select city.*
				        from city 
						where city.id = $idCity");

			$city = $stmt->fetch(PDO::FETCH_ASSOC);
			$idState = $city["id_state"];

			$stmt = DB::getConn()->query("select state.*
				        from state 
						where state.id = $idState");

			$state = $stmt->fetch(PDO::FETCH_ASSOC);
			$idCountry = $state["id_country"];

			$stmt = DB::getConn()->query("select country.*
				        from country 
						where country.id = $idCountry");

			$country = $stmt->fetch(PDO::FETCH_ASSOC);

			$stmt = DB::getConn()->query("select rating.*
				        from rating 
						where rating.id_place = $idPlace");

			$temp_ratings = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$ratings = array();
			foreach ($temp_ratings as $rating) {
				$idUser = $rating["id_user"];
				$stmt = DB::getConn()->query("select user.*
				        from user 
						where user.id = $idUser");

				$user = $stmt->fetch(PDO::FETCH_ASSOC);

				$rating["user"]=$user;
				array_push($ratings, $rating);
			}

			$state["country"] = $country;
			$city["state"] = $state;
			$district["city"] = $city;
			$place["district"] = $district;
			$place["category"] = $category;
			if(sizeof($ratings)>0){
				$place["ratings"] = $ratings;	
			}
			
			array_push($places, $place);
		}
		$array_response["places"] = $places;

		return $array_response;
	}
}