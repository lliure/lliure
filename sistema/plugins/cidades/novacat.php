<?php
retornaLink($historico, 'save');
$case = (isset($_GET['case'])?$_GET['case']: "");
$tabela = SUFIXO."cidades";

$in = "INSERT INTO ".$tabela." (nome) VALUES ('Cidade')";


if (mysql_query($in)) {
	echo mensagemAviso('Cidade criada com sucesso!');
	?>
	<meta http-equiv="refresh" content="1; URL=<?=$pluginHome?>&amp;acoes=categorias<?=(isset($_GET['idCat'])?'&idCat='.$_GET['idCat']:'')?>">
	<?
} else {
	echo mensagemAviso('Erro ao criar cidade, tente novamente mais tarde..');
}

?>

