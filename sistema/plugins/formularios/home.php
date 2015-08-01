<?php

// gambi
$sql = "SELECT id_form FROM ".$pluginTable."_campos GROUP BY id_form";
$qry = mysql_query($sql);
while ($dados = mysql_fetch_array($qry)) {
	$sql2 = "SELECT id FROM ".$pluginTable." where id = '".$dados['id_form']."'";
	$c = 1;
	$idToDie = '';
	if (mysql_num_rows(mysql_query($sql2)) == 0) {
		$idToDie .= ($c!=1?',':'').$dados['id_form'];
		$c++;
	}
}
if (isset($idToDie)) {
	$sql = "DELETE FROM ".$pluginTable."_campos where id_form in ('".$idToDie."')";
	mysql_query($sql);
}
// ; end ; gambi ;


$consulta = "select * from ".$pluginTable." order by nome asc";
$query = mysql_query($consulta);
?>

<div class="menuSub">
	<a href="index.php" title="voltar"><img src="imagens/icones/back.png" alt="voltar"/><span>Voltar para home</span></a>

	<a href="<?=$pluginHome?>&amp;acoes=novo"><img src="<?=$pluginPasta?>img/newfile.png" alt="Criar página"/><span>Criar formulário</span></a>
	<div class="both"></div>
</div>
<?php
$click['link'] = $pluginHome.'&amp;acoes=editar&amp;id=';
$mensagemVazio = "Nenhum formulário encontrado, Clique no botão <strong>Criar formulário</strong> para criar seus formulários";
jNavigator($query, $pluginTable, $pluginPasta, $mensagemVazio, $click);
?>