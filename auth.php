<?php
if(isset($_POST["submit"])){
	if($_POST["submit"]=="send"){	

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $_POST["url"]);
		curl_setopt($ch, CURLOPT_POST, 1);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, array("method"=>$_POST["method"],"data"=>$_POST["data"]));
		//var_dump(json_encode(array("method"=>$_POST["method"],"data"=>$_POST["data"])));
		curl_setopt($ch, CURLOPT_POSTFIELDS, array("json"=>json_encode(array("method"=>$_POST["method"],"id_cat"=>$_POST["data"]))));
		//curl_setopt($ch, CURLOPT_POSTFIELDS, array("data"=>$_POST["data"]));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);  // RETURN THE CONTENTS OF THE CALL
		$resp = curl_exec($ch);
		curl_close($ch);
		echo $resp;
	}
}
?>