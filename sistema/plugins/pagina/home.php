<?php
$consulta = "select * from ".$pluginTable." order by nome asc";
$query = mysql_query($consulta);
?>

<div class="menuSub">
	<a href="<?=$backReal?>" title="voltar"><img src="imagens/icones/back.png" alt="voltar"/><span><?=$backNome?></span></a>  

	<a href="<?=$pluginHome?>&amp;acoes=nova"><img src="<?=$pluginPasta?>img/newfile.png" alt="Criar página"/><span>Criar página</span></a>
	<div class="both"></div>
</div>
<?php
$click['link'] = '?plugin=pagina&amp;acoes=editar&amp;id=';

$mensagemVazio = "Nenhuma página encontrada, Clique no botão <strong>Criar página</strong> para criar suas páginas";
jNavigator($query, $pluginTable, $pluginPasta, $mensagemVazio, $click);
?>