<?php
$consulta = "select * from ".$pluginTable." order by nome asc";
$query = mysql_query($consulta);
?>

<div class="menuSub">
	<a href="<?=$backReal?>" title="voltar"><img src="imagens/icones/back.png" alt="voltar"/><span><?=$backNome?></span></a>  

	<a href="<?=$pluginHome?>&amp;acoes=novo"><img src="<?=$pluginPasta?>img/newfile.png" alt="Criar p�gina"/><span>Criar mapa</span></a>
	<div class="both"></div>
</div>
<?php
$click['link'] = $pluginHome.'&amp;acoes=editar&amp;id=';

$mensagemVazio = "Nenhuma p�gina encontrada, Clique no bot�o <strong>Criar mapa</strong> para criar suas p�ginas";
jNavigator($query, $pluginTable, $pluginPasta, $mensagemVazio, $click);
?>