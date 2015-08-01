<?php
$pluginTable = SUFIXO."cidades";


$where = '';
$maisLink = '';

$consulta = "select * from ".$pluginTable." where 1=1 ".$where." order by nome asc";
$query = mysql_query($consulta);
?>

<div class="menuSub">
	<a href="<?=$pluginHome?>&amp;<?=(!isset($_GET['idCat'])?'back':'acoes=categorias')?>" title="voltar"><img src="imagens/icones/back.png" alt="voltar"/><span>Voltar</span></a>
	
	<a href="<?=$pluginHome?>&amp;acoes=novacat<?=$maisLink?>"><img src="<?=$pluginPasta?>img/newcat.png" alt="Nova Cidade"/><span>Nova Cidade</span></a>

	<div class="both"></div>
</div>
<?php
$click['link'] = $pluginHome.'&amp;acoes=produtos&idCat=';

$mensagemVazio = "Nenhuma categoria encontrada, Clique no botão <strong>Nova categoria</strong> para criar uma nova categoria";
jNavigator($query, $pluginTable, $pluginPasta, $mensagemVazio, $click);
?>