<?php
	// Turned the code structure to endpoint system
	session_start(); 

	Global $selfID;

	if(isset($_SESSION["id"])){
		$selfID = $_SESSION["id"];
	}

	include("./tech/tech.php");
	include("requestHandler.php");

	include("./processment/cpn.php");
	
	conectar();
	header('Content-Type: text/html; charset=utf-8');

	requestHandler($_POST);
	
?>