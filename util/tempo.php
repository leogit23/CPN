<?php
	function compararDatas($data, $dataa){
		$data = strtotime($data);
		$dataAt = strtotime($dataa);
		
		$intervalo  = abs($dataAt - $data);
		$minutos   = round($intervalo / 60);
		
		return $minutos;
	}

	function pegarSegundo(){
		return date("s");
	}
	
	function pegarMinuto(){
		return date("i");
	}
	
	function pegarHora(){
		return date("H");
	}
	
	function horario(){
		return pegarHora() .":". pegarMinuto();
	}
	
	function pegarAno(){
		return date("Y");
	}
	
	function pegarMes(){
		return date("m");
	}
	
	function pegarDia(){
		return date("d");
	}
	
	function pegarSoHorario(){
		return pegarHora() .":". pegarMinuto() .":". pegarSegundo();
	}
	
	function pegarSoData(){
		return pegarAno() ."-". pegarMes() ."-". pegarDia();
	}
	
	function pegarDataCompleta(){
		return pegarSoData() ." ". pegarSoHorario();
	}
	
	function pegarDiaSem(){ //pegar dia semana
		return date("w");
	}
	
	function dataAlfa($br){
		return substr($br, 6) ."-". substr($br, 3, 2) ."-". substr($br, 0, 2);
	}
?>