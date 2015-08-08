<?php
	require_once("../../includes/conection.php"); 
	require_once("../../includes/functions.php"); 
		
	$tabela = PREFIXO.$_GET['tabela'].'_fotos';
	
	$id = $_GET['id'];
	$arquivo = $_GET['arquivo'];
	
	$alter['id'] = $id;
	
	@unlink($arquivo);
	
	mLdelete($tabela, $alter);
?>
<img src="erro.jpg" onerror="show_hide('div<?php echo $id?>')" alt="" class="imge"/>