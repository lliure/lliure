<?php
	require_once("../../../includes/conection.php"); 
	require_once("../functions.php"); 
	header("Content-Type: text/html; charset=ISO-8859-1", true);
		
	$tabela = $_GET['tabela'];
	$dados['nome'] 	= $_GET['nome'];
	
	$id = substr($_GET['id'], 4);
	
	$alter['id']	= $id;

	
	mLupdate($tabela, $dados, $alter);
?>
