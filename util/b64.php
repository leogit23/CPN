<?php
	//validarImagem("../fotosperfil/rukgijopfmhpkglf", "jpg");

	//include("./image.php");
	
	function validarImagem($imgdir, $extt) {
		$filename = $imgdir ."/fototemp.". $extt;
		$outputname = $imgdir ."/foto.". $extt;
		
		$image; $tipo;
		if(( strcasecmp($extt, "jpg") == 0 || strcasecmp($extt, "jpeg") == 0 || strcasecmp($extt, "jpe") == 0)){ $image = @imagecreatefromjpeg($filename); $tipo = 0; }
		if(strcasecmp($extt, "png") == 0){ $image = @imagecreatefrompng($filename); $tipo = 1; }
		
		if($image == false){
			fix_orientation($filename); return;
		}
		
		if($tipo == 0){
			imagejpeg($image, $outputname); return;
		}
		
		if($tipo == 1){
			imagepng($image, $outputname); return;
		}
	}
	
	function image_fix_orientation($imgdir, $extt) {
		$filename = $imgdir ."/fototemp.". $extt;
		$outputname = $imgdir ."/foto.". $extt;
		ini_set ('gd.jpeg_ignore_warning', 1); 
		$image;
		if(( strcasecmp($extt, "jpg") == 0 || strcasecmp($extt, "jpeg") == 0 || strcasecmp($extt, "jpe") == 0)){ $image = @imagecreatefromjpeg($filename); }
		if(strcasecmp($extt, "png") == 0){ $image = @imagecreatefrompng($filename); }
		if($image == null) { return; }
		
		$exif = exif_read_data($filename);
		if (!empty($exif['Orientation'])) {
			switch ($exif['Orientation']) {
				case 3:
					$image = imagerotate($image, 180, 0);  echo("A");
					if(( strcasecmp($extt, "jpg") == 0 || strcasecmp($extt, "jpeg") == 0 || strcasecmp($extt, "jpe") == 0)){ imagejpeg($image, $outputname); }
					if(strcasecmp($extt, "png") == 0){ imagepng($image, $outputname); }
					continue;

				case 6:
					$image = imagerotate($image, 270, 0);   echo("B");//echo("6"); exit;
					if(( strcasecmp($extt, "jpg") == 0 || strcasecmp($extt, "jpeg") == 0 || strcasecmp($extt, "jpe") == 0)){ imagejpeg($image, $outputname); }
					if(strcasecmp($extt, "png") == 0){ imagepng($image, $outputname); }
					continue;

				case 8:
					$image = imagerotate($image, 90, 0); file_put_contents("./jaksdbkabsd.akdsn", "C");  echo("C"); //echo("9"); exit;
					if(( strcasecmp($extt, "jpg") == 0 || strcasecmp($extt, "jpeg") == 0 || strcasecmp($extt, "jpe") == 0)){ imagejpeg($image, $outputname); }
					if(strcasecmp($extt, "png") == 0){ imagepng($image, $outputname); }
					continue;
			}
			//unlink($filename);
			imagedestroy($image);
		}
	}
	
	function fixSOS($imgdir, $ext){
		ini_set ('gd.jpeg_ignore_warning', 1); 
		$tipo = null;
		
		if( $ext == "jpg" || $ext == "jpeg" || $ext == "jpe" ) { $tipo = 1; }
		if( $ext == "png" ){ $tipo = 2; }
		if($tipo == null) { echo "BAD REQUEST."; exit; }
		
		if($tipo == 1) { $imgx = @imagecreatefromjpeg($imgdir . "/fototemp.". $ext); }
		if($tipo == 2) { $imgx = @imagecreatefrompng($imgdir . "/fototemp.". $ext); }
	
		$rotate = imagerotate($imgx, 270, 0); 
		
		if($tipo == 1) { imagejpeg($rotate, $imgdir . "/foto.". $ext); }
		if($tipo == 2) { imagepng($rotate, $imgdir . "/foto.". $ext); }
		
		imagedestroy($rotate);
		imagedestroy($imgx);
	}

	function fotoOnline($origi, $salvarem, $tipo){
		if($tipo == 1){ $gd = imagecreatefromjpeg($origi); }
		if($tipo == 2){ $gd = imagecreatefrompng($origi); }
		
		$dim = getimagesize($origi);
		$cor = imagecolorallocate($gd, 0, 200, 0);
		$c = 0;
		while($c != 6){
			for($x = 0; $x < $dim[0]; $x++){
				if($c > 2){
					imagesetpixel($gd, $x, ($dim[1] - $c) + 2, $cor);
				}
				else{
					imagesetpixel($gd, $x, $c, $cor);
				}
			}
			$c++;
		}
		
		$c = 0;
		while($c != 6){
			for($x = 0; $x < $dim[1]; $x++){
				if($c > 2){
					imagesetpixel($gd, ($dim[0] - 3) + ($c - 3), $x, $cor);
				}
				else{
					imagesetpixel($gd, $c, $x, $cor);
				}
			}
			$c++;
		}
		
		if($tipo == 1){ imagejpeg($gd, $salvarem); }
		if($tipo == 2){ imagepng($gd, $salvarem); }
	}

	function redimFoto($caminho, $novo, $arr, $tipo){
		list($width, $height) = getimagesize($caminho);

		$newwidth = $arr[0];
		$newheight = $arr[1];

		$thumb = imagecreatetruecolor($newwidth, $newheight);
		if($tipo == 1){ $source = @imagecreatefromjpeg($caminho); }
		if($tipo == 2){ $source = imagecreatefrompng($caminho); }

		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

		if (file_exists($novo)) {
			unlink($novo);
		}
		
		if($tipo == 1){ imagejpeg($thumb, $novo); }
		if($tipo == 2){ imagepng($thumb, $novo); }
		//imagejpeg($thumb); //mostra
	}
?>