<?php
	retornaLink($historico, 'save');
		
	$alter['id'] = $_GET['video'];

	mLdelete($pluginTable, $alter);
	
	echo mensagemAviso("Vídeo foi excluído.");
	
	require_once("album.php");
?>
