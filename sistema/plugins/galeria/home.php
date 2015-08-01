<?php

$consulta = "select * from ".$pluginTable.$filtro;
$query = mysql_query($consulta);
?>
<div class="menuSub">
	<a href="<?=$backReal?>" title="voltar"><img src="imagens/icones/back.png" alt="voltar"/><span><?=$backNome?></span></a>  
	<?php 
	if(!isset($_GET['gal'])){
		?>
		<a href="<?=$pluginHome?>&amp;acoes=novogal<?=$linkGal?>"><img src="<?=$pluginPasta?>img/newbook.png" alt="Criar galeria"/><span>Criar galeria</span></a>
		<?php
	}
	?>
	<a href="<?=$pluginHome?>&amp;acoes=nova<?=$linkGal?>"><img src="<?=$pluginPasta?>img/new.png" alt="Criar album"/><span>Criar album</span></a>
	
	<div class="both"></div>
</div>

<?php
$click['ver'] = 'tipo';

$click['condicao']['0'] = 't1';
$click['condicao']['1'] = 't2';

$click['t1']['link'] = $pluginHome."&amp;acoes=editar&amp;id=";
$click['t1']['ico'] = "/img/album.png";

$click['t2']['link'] = $pluginHome."&amp;gal=";
$click['t2']['ico'] = "/img/book.png";

$mensagemVazio = "Nenhum album encontrado.";
jNavigator($query, $pluginTable, $pluginPasta, $mensagemVazio, $click);
?>