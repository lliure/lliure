<?php
$consulta = "select * from ".$pluginTable." order by nome asc";
$query = mysql_query($consulta);
?>
<div class="menuSub">
	<a href="<?=$backReal?>" title="voltar"><img src="imagens/icones/back.png" alt="voltar"/><span><?=$backNome?></span></a>  
	
	<a href="<?=$pluginHome?>&amp;acoes=novo"><img src="<?=$pluginPasta?>img/newCat.png" alt="Criar noticiario"/><span>Criar noticiario</span></a>
	
	<div class="both"></div>
</div>

<?php
if((!isset($_GET['goback'])) and (mysql_num_rows($query) == 1)){
	$dados = mysql_fetch_array($query);
	echo mensagemAviso("Aguarde...");
	?>
	<meta http-equiv="refresh" content="0; URL=<?=$pluginHome?>&amp;acoes=noticiario&amp;id=<?=$dados['id']?>">
	<?php
} else {
$click['link'] = $pluginHome."&amp;acoes=noticiario&amp;id=";
$click['ico'] = '/img/noticiario.png';

$mensagemVazio = "Nenhum noticiarios encontrado.";
jNavigator($query, $pluginTable, $pluginPasta, $mensagemVazio, $click);
}
?>