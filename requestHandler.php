<?php

function requestHandler($POST){
	if(isset($POST["requestHeader"])){
		$header = $POST["requestHeader"];

		$body = array();
		if(isset($POST["requestBody"])){
			$encoded = json_encode($POST["requestBody"]);
			$body = json_decode($encoded);
		}

		$header($body);
	}
}

?>