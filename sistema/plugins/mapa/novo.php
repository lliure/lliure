<?php
	
	$dados['nome'] = "Novo mapa";
	
	if(isset($_GET['id'])){
		$dados['id'] = $_GET['id'];
	}	
	
	mLinsert($pluginTable, $dados);
	echo mensagemAviso("Novo mapa criado com sucesso.");
	
	require_once("home.php");
?>