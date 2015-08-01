<?php
if(isset($_GET['novo'])){
	require_once('new.php');
}

$consulta = "select * from ".$pluginTable;
$query = mysql_query($consulta." where categoria is NULL");
?>

<div class="menuSub">
	<a href="<?=$backReal?>" title="voltar"><img src="imagens/icones/back.png" alt="voltar"/><span><?=$backNome?></span></a>  
	
	<a href="<?=$pluginHome?>&amp;novo" title="Criar Menu"><img src="<?=$pluginPasta ?>img/newmenu.png" alt="voltar"/><span>Criar Menu</span></a>
	
	<div class="both"></div>
</div>

<div class="both"></div>

<?php
if((!isset($_GET['goback'])) and (mysql_num_rows($query) == 1)){
	echo mensagemAviso("Aguarde...");
	$dados = mysql_fetch_array($query);
	echo loadPage($pluginHome."&local=menus&id=".$dados['id']);
} else {
	$click['ico'] = "img/menu.png";
	$click['link'] = $pluginHome."&amp;local=menus&amp;id=";
	$mensagemVazio = "Nenhum menu encontrado, Clique no botão <strong>Criar menu</strong> criar seus menus.";
	jNavigator($query, $pluginTable, $pluginPasta, $mensagemVazio, $click);
}
?>