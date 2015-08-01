<?php
$pluginTable = SUFIXO."catalogo_categorias";

// gambi
if (!isset($_GET['idCat'])) {

	function deletaTudo($idLig) {
		
		$sql = "SELECT id FROM ".SUFIXO."catalogo_categorias where idLig = '".$idLig."'";
		$qry = mysql_query($sql);
		while ($dados = mysql_fetch_array($qry)) {
			$del = "DELETE FROM ".SUFIXO."catalogo_categorias where idLig = '".$idLig."'";
			mysql_query($del);
			
			$del = "DELETE FROM ".SUFIXO."catalogo_categorias where idLig = '".$dados['id']."'";
			
			mysql_query($del);
			deletaTudo($dados['id']);	
		}
	}
	
	$sql = "SELECT idLig FROM ".$pluginTable." GROUP BY idLig";
	$qry = mysql_query($sql);
	while ($dados = mysql_fetch_array($qry)) {
		if ($dados['idLig'] != '0') { 
			$sql2 = "SELECT id FROM ".$pluginTable." where id = '".$dados['idLig']."'";
			if (mysql_num_rows(mysql_query($sql2)) == 0) {
				deletaTudo($dados['idLig']);
			}
		}
	}
}
// ; end ; gambi ;


$where = '';
$maisLink = '';
if (isset($_GET['idCat'])) {
	$where .= " and idLig = '".$_GET['idCat']."'";
	$maisLink = '&idCat='.$_GET['idCat'];
} else {
	$where .= " and idLig = '0'";
}
$consulta = "select * from ".$pluginTable." where 1=1 ".$where." order by nome asc";
$query = mysql_query($consulta);
?>

<div class="menuSub">
	<a href="<?=$pluginHome?>&amp;<?=(!isset($_GET['idCat'])?'back':'acoes=categorias')?>" title="voltar"><img src="imagens/icones/back.png" alt="voltar"/><span>Voltar</span></a>
	
	<a href="<?=$pluginHome?>&amp;acoes=novacat<?=$maisLink?>"><img src="<?=$pluginPasta?>img/newcat.png" alt="Nova categoria"/><span>Nova categoria</span></a>

	<div class="both"></div>
</div>
<?php
$click['link'] = $pluginHome.'&amp;acoes=produtos&idCat=';

$mensagemVazio = "Nenhuma categoria encontrada, Clique no botão <strong>Nova categoria</strong> para criar uma nova categoria";
jNavigator($query, $pluginTable, $pluginPasta, $mensagemVazio, $click);
?>