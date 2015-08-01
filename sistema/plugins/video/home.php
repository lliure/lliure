<?php
$consulta = "select * from ".$pluginTable." where album = '0' order by nome asc";
$query = mysql_query($consulta);
?>
<div class="menuSub">
	<a href="<?=$backReal?>" title="voltar"><img src="imagens/icones/back.png" alt="voltar"/><span><?=$backNome?></span></a>  
	
	<a href="<?=$pluginHome?>&amp;acoes=new"><img src="<?=$pluginPasta?>img/newbook.png" alt="Criar album"/><span>Criar album</span></a>
	
	<div class="both"></div>
</div>

<?php
	$click['link'] = $pluginHome."&amp;acoes=album&amp;id=";
	$click['ico'] = '/img/book.png';

	$mensagemVazio = "Nenhum album encontrado.";
	jNavigator($query, $pluginTable, $pluginPasta, $mensagemVazio, $click);
?>