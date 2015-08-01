<?php
header("Content-type: image/jpeg");

$formanome = explode("::", $_GET['imagem']);

$im = $formanome['1'];

// Cria uma nova imagem a partir de um arquivo ou URL
if(strstr($im, ".jpg") != false){
	$im = imagecreatefromjpeg($im); 
} elseif(strstr($im, ".png") != false){
	$im = imagecreatefrompng($im); 
} elseif(strstr($im, ".gif") != false){
	$im = imagecreatefromgif($im); 
}

$wid = $formanome['0'];
$hei = $formanome['2'];

$origem_x = ImagesX($im);
$origem_y = ImagesY($im);

//VERIFICA VALOR MAIOR
if($origem_x > $origem_y) { 
	$percentual = $wid*100/$origem_x;

} else {
	$percentual = $hei*100/$origem_y;
}

$widn = intval ($origem_x * $percentual/100);
$hein = intval ($origem_y * $percentual/100);

//Sertifica que os tamanhos estão corretos
if(($hein > $hei) or ($widn > $wid)){
	if($hein > $hei){
		$percentual = $hei*100/$hein;
	} elseif($widn > $wid){
		$percentual = $wid*100/$widn;
	}

	$widn = intval ($widn * $percentual/100);
	$hein = intval ($hein * $percentual/100);
	

}

$left = ($wid-$widn)/2;
$top = ($hei-$hein)/2;

$img = NULL;
$img = imagecreatetruecolor($wid, $hei);

// Troca o fundo da imagem
$white = imagecolorallocate($im, 255, 255, 255);
imagefill($img, 0, 0, $white); 
 
imagecopyresampled($img, $im, $left, $top, 0, 0, $widn, $hein, $origem_x, $origem_y);

if(strstr($im, ".jpg") != false){
	imagejpeg($img);
} elseif(strstr($im, ".png") != false){
	imagepng($img);
} elseif(strstr($im, ".gif") != false){
	imagegif($img);
}

?>