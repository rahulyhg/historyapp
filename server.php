<?php 
header ('Content-type: text/html; charset=UTF-8');

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
    printf("Error loading character set utf8: %s\n", $conn->error);
}

function pop_user($model){
	$array_user = array(
			"id"=>$model["id"],
			"name"=>$model["name"],
			"email"=>$model["email"],
			"picture_profile"=>$model["picture_profile"]
			);
	return $array_user;
}

function pop_place($model){
	$array_place = array(
			"id"=>$model["id"],
			"id_district"=>$model["id_district"],
			"name"=>$model["name"],
			"addr"=>$model["addr"],
			"location"=>$model["location"],
			"picture_place"=>$model["picture_place"]
			);
	return $array_place;
}




/*

if(isset($_POST['method'])){

	if(strcmp('object', $_POST['method']) == 0){
		$method = $_POST['method'];
		$dados = $_POST['data'];
		$mensagem_para_enviar = "MEDOTO: ".$method." | DADOS: ".$dados;
		echo json_encode(array('mensagem'=>$mensagem_para_enviar));
	}

	else if(strcmp('array', $_POST['method']) == 0){
		$method = $_POST['method'];
		$dados = $_POST['data'];
		$mensagem_para_enviar = "METODO: ".$method." | DADOS: ".$dados;

		$array = array();
		array_push($array, array('mensagem'=>$mensagem_para_enviar)); 
		
		$array_final = array();
		array_push($array_final, $array);
		echo json_encode($array);
	}

	else{
		echo "erro no methos";
	}

}else{
	echo "erro geral";
}

 ?>*/