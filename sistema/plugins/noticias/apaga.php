<?php

	$alter['id'] = $_GET['id'];
	mLdelete($pluginTable, $alter);
	echo mensagemAviso("Noticia apagada com sucesso!");
?>
<meta http-equiv="refresh" content="1; URL=<?=$pluginHome?>&amp;acoes=noticiario&id=<?=$_GET['cat']?>">