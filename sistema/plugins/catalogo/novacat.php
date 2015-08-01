<?php
retornaLink($historico, 'save');
$case = (isset($_GET['case'])?$_GET['case']: "");
$tabela = SUFIXO."catalogo_categorias";
if (!isset($_GET['idCat'])) {
	$in = "INSERT INTO ".$tabela." (nome) VALUES ('Categoria')";
} else {
	$in = "INSERT INTO ".$tabela." (nome,idLig) VALUES ('SubCategoria','".$_GET['idCat']."')";
}

if (mysql_query($in)) {
	echo mensagemAviso('Categoria criada com sucesso!');
	?>
	<meta http-equiv="refresh" content="1; URL=<?=$pluginHome?>&amp;acoes=categorias<?=(isset($_GET['idCat'])?'&idCat='.$_GET['idCat']:'')?>">
	<?
} else {
	echo mensagemAviso('Erro ao criar categoria, tente novamente mais tarde..');
}

?>

