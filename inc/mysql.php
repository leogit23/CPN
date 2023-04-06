<?php

	$gloCon = "";

	function conectar(){ global $gloCon;
		//######## TROCAR DADO FIXO PELO DADO DA INSTALAÇÃO #########
		$gloCon = mysqli_connect("127.0.0.1", "root", "", "cpn");
		mysqli_set_charset($gloCon, "utf8mb4");	
	}
	
	function usesql(){ global $gloCon;
		$gloCon = mysqli_connect("127.0.0.1", "root", "", "");
		mysqli_set_charset($gloCon, "utf8mb4");	
	}
	
	function desconectar(){ global $gloCon;
		mysqli_close($gloCon);
	}
	
	function mexec($str){ global $gloCon;
		mysqli_query($gloCon, $str);
	}
	
	function sec($str){ global $gloCon;
		return mysqli_escape_string($gloCon, $str);
	}
	
	function lastid(){ global $gloCon;
		return mysqli_insert_id($gloCon);
	}
	
	//sql 2.0
	
	function resultados($querie, $campos){ global $gloCon;
		if (preg_match('/#col/', $querie)){
			$querie = str_replace(array("#cols"), convcols($campos), $querie);
		}
		//echo $querie;
		
		$retval = mysqli_query($gloCon, $querie) or die('Nenhum dado obtido: ' . mysqli_error($gloCon));

		$ret = array();
		$c = 0;
		while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
			for($i = 0; $i < count($campos); $i++){
				$ret[$c] = $row[$campos[$i]];
				$c++;
			}
		}
		
		return $ret;
	}
	
	function cheQuerie($querie){ global $gloCon;
		$retval = mysqli_query($gloCon, $querie); if(!$retval){ die('Nenhum dado obtido: ' . mysqli_error($gloCon)); }
		
		if(mysqli_fetch_array($retval, MYSQLI_ASSOC) == false){
			return false;
		}
		return true;
	}
		
	function proxRes($q, $cols){ global $gloCon;
		$res = mysqli_fetch_array($q, MYSQLI_ASSOC);
		
		$arr = array(); $c = 0;
		for($i = 0; $i < count($cols); $i++){
			if(isset($res[$cols[$i]])){
				$arr[$c] = $res[$cols[$i]]; 
				$c++;	
			}
		}
		
		return $arr;
	}
	
	function convAspas($arr){
		return sepAspas($arr, ",");
	}
	
	function convcols($arr){
		return exModelsep($arr, ",");
	}
	
	function exModelsep($arr, $sep){
		$exMod = "";
		for($i = 0; $i < count($arr); $i++){
			if($i == count($arr) - 1) { $exMod = $exMod . $arr[$i]; break;  }
			$exMod = $exMod . $arr[$i] . $sep;
		}
		return $exMod;
	}
	
	function sepAspas($arr, $sep){
		$exMod = "";
		for($i = 0; $i < count($arr); $i++){
			if($i == count($arr) - 1) { $exMod = $exMod . "'" . $arr[$i] ."'"; break;  }
			$exMod = $exMod . "'". $arr[$i] ."'". $sep;
		}
		return $exMod;
	}
	
	function updateQ($dad){ //nome = 'tal'
		$str = "";
		for($i = 0; $i < count($dad); $i = $i + 2){
			if($i == count($dad) - 2){
				$str = $str . $dad[$i] . " = '". $dad[$i + 1] ."'"; break;
			}
			$str = $str . $dad[$i] . " = '". $dad[$i + 1] ."', ";
		}
		
		return $str;
	}
	
	function gOr($arr, $coluna){ //GIGANT OR
		$q = "";
		for($i = 0; $i < count($arr); $i++){
			if($i == 0){
				$q = $coluna . " = '". $arr[$i] ."'";
				continue;
			}
			
			$q = $q . " OR ". $coluna ." = '". $arr[$i] ."'";
		}
		return $q;
	}
	
	function linUpd($cols, $infs){ //linear update
		if(count($cols) != count($infs)){
			return array();
		}
		
		$novo = array(); $c = 0;
		for($i = 0; $i < count($cols); $i++){
			$novo[$c] = $cols[$i];
			$novo[$c + 1] = $infs[$i];
			
			$c = $c + 2;
		}
		return $novo;
	}
	
	function arrCol($str){
		return explode(";", $str);
	}
	
	function select($tab, $cols, $wh){
		//echo "SELECT #cols FROM ". $tab ." ". $wh;
		return resultados("SELECT #cols FROM ". $tab ." ". $wh, $cols); //converted q
	}
	
	function singleQuery($tab, $col, $wh){
		$res = resultados("SELECT #cols FROM ". $tab ." ". $wh, $col);

		if(count($res) <= 0){
			return "scripter-empty";
		}

		$out[$col[0]] = $res[0];
		return $out;
	}

	function singleData($tab, $col, $wh){
		$res = resultados("SELECT #cols FROM ". $tab ." ". $wh, $col);

		if(count($res) <= 0){
			return "scripter-empty";
		}

		return $res[0];
	}

	function oneRow($tab, $cols, $wh){
		$values = resultados("SELECT #cols FROM ". $tab ." ". $wh, $cols);
		
		$return = array();
		
		$counter = 0;
		$line = 0;
		$out = array();
		foreach ( $values AS $field ) {
			$out[$cols[$counter]] = $field;
			$counter++;
			
			if($counter == count($cols)){
				$counter = 0;
				$line++;
				break;
			}
		}
		
		return $out;
	}
	
	function queryBy($tab, $cols, $wh){
		$values = resultados("SELECT #cols FROM ". $tab ." ". $wh, $cols);
		
		$return = array();
		//s$obj = array();
		
		$counter = 0;
		$line = 0;
		$out = array();
		foreach ( $values AS $field ) {
			$out[$line][$cols[$counter]] = $field;
			$counter++;
			
			if($counter == count($cols)){
				$counter = 0;
				$line++;
			}
		}
		
		return $out;

	}
	
	function insert($tab, $cols, $vals){
		mexec("INSERT INTO ". $tab ."(". convcols($cols) .") VALUES(". convAspas($vals) .")");
	}
	
	function update($tab, $infos, $wh){
		//echo "UPDATE ". $tab ." SET ". updateQ($infos) ." ". $wh;
		mexec("UPDATE ". $tab ." SET ". updateQ($infos) ." ". $wh);
	}
	
	function sqlexit(){ desconectar(); exit; }
?>
