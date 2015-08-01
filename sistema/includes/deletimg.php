<?php
	require_once("../../includes/conection.php"); 
	require_once("functions.php"); 
		
	$tabela = SUFIXO.$_GET['tabela'];
	
	$id = $_GET['id'];
	$arquivo = $_GET['arquivo'];
	
	$alter['id'] = $id;
	
	
	@unlink($arquivo);
	
	mLdelete($tabela, $alter);
?>
<img src="erro.jpg" onerror="show_hide('div<?=$id?>')" alt="" class="imge"/>