<?php
$consulta = "select * from ".$pluginTable." order by nome asc";
$query = mysql_query($consulta);
?>
<div class="menuSub">
	<a href="<?=$backReal?>" title="voltar"><img src="imagens/icones/back.png" alt="voltar"/><span><?=$backNome?></span></a>  
	
	<a href="<?=$pluginHome?>&amp;acoes=novo"><img src="<?=$pluginPasta?>img/new.png" alt="Criar album"/><span>Criar evento</span></a>
	
	<div class="both"></div>
</div>

<?php
$click['link'] = $pluginHome."&amp;acoes=editar&amp;id=";

$mensagemVazio = "Nenhum evento encontrado.";
jNavigator($query, $pluginTable, $pluginPasta, $mensagemVazio, $click);
?>