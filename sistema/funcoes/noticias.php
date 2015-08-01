<?php
function mLUltNoticias($limit = 1, $exata = 0){
	$exata = ($exata === 0?'':" where categoria ='".$exata."'");
	$consultaNoticias = "SELECT * FROM ".SUFIXO."noticias $exata order by id desc limit ".$limit;
	$queryNoticias = mysql_query($consultaNoticias);
	while($dadosNoticias = mysql_fetch_array($queryNoticias)){
		?>
		<div class="noticias">
			<span class="titulo"><a href="?noticias=1&id=<?=$dados['id']?>"><?=$dadosNoticias['titulo']?></a></span>
			<div class="texto"><?=mLsubstrFull($dadosNoticias['texto'],300)?></div>
			<span class="vejamais"><a href="?noticias=1&id=<?=$dados['id']?>">[Leia mais]</a></span>
		</div>
		<?php
	}
}


?>