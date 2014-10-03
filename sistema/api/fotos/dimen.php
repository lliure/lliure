<?php
/**
*
* lliure WAP
*
* @Vers�o 6.0
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br/
* @Licen�a http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
// l� a imagem de origem e obt�m suas dimens�es
$img_origem = ImageCreateFromJPEG($imagem);
$origem_x = ImagesX($img_origem);
$origem_y = ImagesY($img_origem);

$pdy = (!isset($pdy)?$pdt:$pdy);

if($origem_x > $pdt || $origem_y > $pdy){	
	//VERIFICA VALOR MAIOR
	if($origem_x > $origem_y) {
		$percentual = $pdt*100/$origem_x;
	} else{
		$percentual = $pdy*100/$origem_y;
	}

	//AJUSTA O TAMANHO DE AMBOS OS TAMANHOS
	$x = intval ($origem_x * $percentual/100);
	$y = intval ($origem_y * $percentual/100);

	// cria a imagem final, que ir� conter a miniatura
	$img_final = ImageCreateTrueColor($x,$y);

	// copia a imagem original redimensionada para dentro da imagem final
	ImageCopyResampled($img_final, $img_origem, 0, 0, 0, 0, $x+1, $y+1, $origem_x , $origem_y);

	// salva o arquivo
	ImageJPEG($img_final, $imagem, 100);

	// libera a mem�ria alocada para as duas imagens
	ImageDestroy($img_origem);
	ImageDestroy($img_final);
}

?>
