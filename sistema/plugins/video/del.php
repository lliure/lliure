<?php
	retornaLink($historico, 'save');
		
	$alter['id'] = $_GET['video'];

	mLdelete($pluginTable, $alter);
	
	echo mensagemAviso("V�deo foi exclu�do.");
	
	require_once("album.php");
?>
