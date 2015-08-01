<?php
	$alter['id'] = $_GET['id'];
	
	unlink("../uploads/banners/".$_GET['arq']);
	mLdelete($pluginTable, $alter);
	echo mensagemAviso("Banner apagado com sucesso!");

?>
<meta http-equiv="refresh" content="1; URL=<?=$pluginHome?>&amp;acoes=banners&id=<?=$_GET['tban']?>">