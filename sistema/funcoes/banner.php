<?php
function mLBanner($tipo = 1, $qnt = 1, $posit = 1){
	$consulta = "select * from ".SUFIXO."banner where tipo = '".$tipo."' order by RAND() limit $qnt";
	$query = mysql_query($consulta);
	while($dados = mysql_fetch_array($query)){
		$imagem = $dados['imagem'];
		$link = $dados['link'];
		$nome = $dados['nome'];
		$titulo = $dados['titulo'];
		
		if(!empty($titulo) && $posit == 1){
			?>
			<span><?=$titulo?></span>
			<?php
		}
		if($link != 'http://'){
			?>
			<a href="<?=$link?>" target="_blank" title="$nome"><img src="uploads/banners/<?=$imagem?>" alt="<?=$nome?>" /></a>
			<?php
		} else {
			?>
			<img src="uploads/banners/<?=$imagem?>" alt="<?=$nome?>" />
			<?php
		}
		if(!empty($titulo) && $posit == 2){
			?>
			<span><?=$titulo?></span>
			<?php
		}
	}
}
?>