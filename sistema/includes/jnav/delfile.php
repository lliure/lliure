<?php
	require_once("../../includes/conection.php"); 
	require_once("../functions.php"); 
	
	$tabela = $_GET['tabela'];
	$id = substr($_GET['id'], 4);
	
	$alter['id']	= $id;

	mLdelete($tabela, $alter);
?>
<img src="error.jpg" onerror="mLaviso('Item excluido com sucesso!', '1')" class="imge" alt="" /> 