<?php
$idMenu  = $_GET['id'];

$consulta = "select idMe, categoria from ".$pluginTable." where id = '$idMenu'";
$query = mysql_fetch_array(mysql_query($consulta));

$categoria 	= $idMenu;

$back = (empty($query['1'])?'&amp;back':'&amp;local=menus&id='.$query['1']);

$new = (!empty($_GET['new'])?$_GET['new']:'defalut');
switch($new){
	case "cat":
		$oQueCria = 'cat';
		require_once("new.php");
	break;
	
	case "link":
		$oQueCria = 'link';
		require_once("new.php");
	break;
}

?>
<div class="menuSub">
	<a href="<?=$backReal?>" title="voltar"><img src="imagens/icones/back.png" alt="voltar"/><span><?=$backNome?></span></a> 
	
	<a href="<?=$pluginHome?>&local=menus&amp;id=<?=$idMenu?>&amp;new=cat" title="Criar categoria"><img src="<?=$pluginPasta ?>img/newcategoria.png" alt="voltar"/><span>Criar categoria</span></a>
	<a href="<?=$pluginHome?>&local=menus&amp;id=<?=$idMenu?>&amp;new=link" title="Criar link"><img src="<?=$pluginPasta ?>img/newlink.png" alt="voltar"/><span>Criar link</span></a>
	
	<a href="<?=$pluginHome?>&local=ordenar&amp;id=<?=$idMenu?>" title="Criar link"><img src="<?=$pluginPasta ?>img/order.png" alt="voltar"/><span>Ordenar</span></a>
	
	<div class="both"></div>
</div>
<?php

$consulta = "select * from ".$pluginTable;
$query = mysql_query($consulta." where categoria = '$idMenu' order by tipo Asc");

$click['ver'] = 'tipo';

$click['condicao']['NULL'] = 't1';
$click['condicao']['NOT NULL'] = 't2';

$click['t1']['link'] = $pluginHome."&amp;local=menus&amp;id=";
$click['t1']['ico'] = "/img/categoria.png";

$click['t2']['link'] = $pluginHome."&amp;local=link&id=";
$click['t2']['ico'] = "/img/link.png";

$mensagemVazio = "Nenhum menu encontrado, Clique no botão <strong>Criar menu</strong> criar seus menus.";
jNavigator($query, $pluginTable, $pluginPasta, $mensagemVazio, $click);
?>