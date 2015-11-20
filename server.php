<?php 
//header ('Content-type: text/html; charset=UTF-8');
header('Content-Type', 'application/json;charset=utf-8');

/*
* @ localhost = 0;
* @ ica = 1;
* @ hostinger = 2;
*/
$serverLocation = 0;

$host = 'localhost';
$db = 'history_app';
$user = 'root';
$passwd = '';



$conn = new mysqli($host,$user,$passwd,$db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (!$conn->set_charset("utf8")) {
    print_r("Error loading character set utf8: %s\n", $conn->error);
}

/*function pop_user($model){
	$array_user = array(
			"response"=>null,
			"id"=>$model["id"],
			"name"=>$model["name"],
			"email"=>$model["email"],
			"picture_profile"=>$model["picture_profile"]
			);
	return $array_user;
}

function pop_place($model){
	$array_place = array(
		"response"=>null,
			"id"=>$model["id"],
			"id_district"=>$model["id_district"],
			"name"=>$model["name"],
			"addr"=>$model["addr"],
			"location"=>$model["location"],
			"picture_place"=>$model["picture_place"]
			);
	return $array_place;
}*/

if(isset($_POST['method'])){

	//retorna json array
	if(strcmp('list_cats', $_POST['method']) == 0){

		
		$array_response = array();

		$sql = "select * from category";

		$result = $conn->query($sql);

		if($result!=null){
			if($result->num_rows > 0){
				foreach ($result as $model) {
					array_push($array_response,$model);
				}
			}else{
				array_push($array_response,array("id"=>"not_found"));
			}
		}else{
			array_push($array_response,array("id"=>"not_found"));
		}

		echo json_encode($array_response);
	}

	//retorna json array
	else if(strcmp('list_places_by_cats', $_POST['method']) == 0){
		
		$id_cat = $_POST['data'];
		$array_response = array();

		$sql = "select place.*
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
		where place.id_category = $id_cat";

		$result = $conn->query($sql);

		if($result!=null){
			if($result->num_rows > 0){
				foreach ($result as $model) {
					array_push($array_response,$model);
				}
			}else{
				array_push($array_response,array("id"=>"not_found"));
			}	
		}else{
			array_push($array_response,array("id"=>"not_found"));
		}
		
		echo json_encode($array_response);
	}

	//retorna json object
	else if(strcmp('get_place_by_id', $_POST['method']) == 0){
		
		$id_place = $_POST['data'];
		$array_response = array();

		$sql = "select place.*
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
		where place.id = $id_place";

		$result = $conn->query($sql);

		if($result!=null){
			if($result->num_rows > 0){
				foreach ($result as $model) {
					array_push($array_response,$model);
				}
			}else{
				array_push($array_response,array("id"=>"not_found"));
			}	
		}else{
			array_push($array_response,array("id"=>"not_found"));
		}
		
		echo json_encode($array_response);
	}

	//retorna json object
	else if(strcmp('find', $_POST['method']) == 0){
		
		$query = $_POST['data'];
		$array_response = array();

		$sql = "select place.*
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
		where place.name like '%$query%' or
				place.description like '%$query%' or
                place.addr like '%$query%' or
                place.name like '%$query%' or
                district.name like '%$query%' or
                city.name like '%$query%' or
                state.name like '%$query%' or
                country.name like '%$query%'";

		$result = $conn->query($sql);

		if($result!=null){
			if($result->num_rows > 0){
				foreach ($result as $model) {
					array_push($array_response,$model);
				}
			}else{
				array_push($array_response,array("id"=>"not_found"));
			}	
		}else{
			array_push($array_response,array("id"=>"not_found"));
		}
		
		echo json_encode($array_response);
	}

	//retorna json object
	else if(strcmp('set-favorite', $_POST['method']) == 0){
		
		$id_place = $_POST['data'];
		$array_response = array();

		//teu codigo
		
		$array_response = array("id"=>"merro");
		echo json_encode($array_response);
	}

	else{		
		$array_response = array("id"=>"metodo_desconhecido");
		echo json_encode($array_response);
	}

}else{
	
	//RETORNA JSONOBJECT
	echo "PORRA";
	$array_response = array("response"=>"erro_geral");
	echo json_encode($array_response);
}


 ?>


 