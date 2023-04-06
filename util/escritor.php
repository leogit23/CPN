<?php
	function match($str, $chr){
		for($i = 0; $i < strlen($str); $i++){
			if($str[$i] == $chr){
				return true;
			}
		}
		return false;
	}

	function acessar($pagina){
		 $useragent = $_SERVER['HTTP_USER_AGENT'];
		 
		 $strCookie = "";
		 if(isset($_COOKIE['PHPSESSID'])){
			  $strCookie = 'PHPSESSID='. $_COOKIE['PHPSESSID'] .'; path=/';
		 }

		 session_write_close();

		 $ch = curl_init();
		 
		 curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1/". $pagina);
		 curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		 curl_setopt($ch, CURLOPT_COOKIE, $strCookie );
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);

		 curl_exec($ch); 
		 $data = curl_getinfo($ch);
		 
		 //print_r($data);
		 
		/*	 if($data["http_code"] == "200"){
				 echo "200";
			 }*/
		 curl_close($ch); 
		 
		 return $data["http_code"];
	}
	
	function wpost($pagina){ //withpost
		 $useragent = $_SERVER['HTTP_USER_AGENT'];
		 
		 $strCookie = "";
		 if(isset($_COOKIE['PHPSESSID'])){
			  $strCookie = 'PHPSESSID='. $_COOKIE['PHPSESSID'] .'; path=/';
		 }

		 session_write_close();

		 $ch = curl_init();
		 
		 curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:8012/". $pagina);
		 curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		 curl_setopt($ch, CURLOPT_COOKIE, $strCookie );
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
		 curl_setopt($ch, CURLOPT_POSTFIELDS,
            "postvar1=value1&postvar2=value2&postvar3=value3");

		 curl_exec($ch); 
		 curl_close($ch); 
	}
	
	function zecho($pagina){
		 $useragent = $_SERVER['HTTP_USER_AGENT'];
		 $strCookie = 'PHPSESSID='. $_COOKIE['PHPSESSID'] .'; path=/';

		 session_write_close();

		 $ch = curl_init();
		 
		 curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:8080/". $pagina);
		 curl_setopt($ch,CURLOPT_USERAGENT, $useragent);
		 curl_setopt($ch, CURLOPT_COOKIE, $strCookie );
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);

		 echo curl_exec($ch); 
		 curl_close($ch); 
	}

	function remd($str){
		return substr($str, 0, strlen($str) - 1);
	}

	function nextCol($val, $space){
		return repChar(" ", $space - strlen($val));
	}

	function repChar($ch, $x){
		$r = "";
		for ($i = 0; $i < $x; $i++) {
			$r = $r . $ch;
		}
		return $r;
	}

	function proArr($arr, $c, $f){ //process array, começo, fim
		$str = "";
		for($i = $c; $i < $f + 1; $i++){
			$str = $str . $arr[$i] . "";
		}
		return substr($str, 0, strlen($str) - 1);
	}

	function alea($tam){
		$c = 0;
		$r = "";
		while($c != $tam){
			$r = $r . rand(0, 9);
			$c++;
		}
		return $r;
	}

	function serial($tab, $col){
		$serial = alea(7);
		
		if(isset($col) == false){
			$col = "serial";
		}
		
		while(cheQuerie("SELECT id FROM ". $tab ." WHERE ". $col ." = '". $serial ."'")){ $serial = alea(7); }
		return $serial;
	}

	function fByLine($arq){
		$handle = fopen($arq, "r");
		
		$linhas = array();
		$c = 0;
		if($handle){
			while(($line = fgets($handle)) !== false) {
				$linhas[$c] = $line; $c++;
			}

			fclose($handle);
		}
		else { echo "err."; } 
		return $linhas;
	}

	function formatarData($data){
		return substr($data, 6, 4) ."-". substr($data, 3, 2) ."-". substr($data, 0, 2);
	}
	
	function formatarDataEUA($data){
		return substr($data, 8, 2) ."/". substr($data, 5, 2) ."/". substr($data, 0, 4);
	}

	function separar($string, $char){
		$nChars = nChars($string, $char);
		
		if($nChars == 0){
			return null;
		}
		
		$ret = array($nChars);
		
		for($i = 0; $i < $nChars; $i++){
			$ret[$i] = substr($string, 0, strpos($string, $char));
			$string = substr($string, strpos($string, $char) + 1);
		}
		return $ret;
	}
	
	function nChars($string, $char){
		$total = 0;
		
		for($i = 0; $i < strlen($string); $i++){
			$str = $string[$i];
			if(strcasecmp($str, $char) == 0){
				$total++;
			}
		}
		return $total;
	}
	
	function temLetras($str){
		return ctype_digit($str) == false;
	}
	
	function temNumeros($str){
		if (preg_match('#[0-9]#',$str)){
			
			return true;
		}
		else{
			return false;
		} 
	}
	
	function eNumerico($str){
		for($i = 0; $i < strlen($str); $i++){
			if(ord($str[$i]) != 48 && ord($str[$i]) != 49 && ord($str[$i]) != 50 && ord($str[$i]) != 51 && ord($str[$i]) != 52 && ord($str[$i]) != 53 && ord($str[$i]) != 54 && ord($str[$i]) != 55 && ord($str[$i]) != 56 && ord($str[$i]) != 57){
				return false;
			}
		}
		return true;
	}
	
	function soNumeros($comOutros){
		$soNumeros = "";
		
		for($i = 0; $i < strlen($comOutros); $i++){
			if(eNumerico($comOutros[$i])){
				$soNumeros .= $comOutros[$i];
			}
		}
		
		if($soNumeros == ""){
			return "0";
		}
		
		return $soNumeros;
	}
?>