<?php
	$dados['nome'] = "Novo Evento";
	
	if(isset($_GET['id'])){
		$dados['id'] = $_GET['id'];
	}	
	
	mLinsert($pluginTable, $dados);
	echo mensagemAviso("Novo evento criado com sucesso.");
	
	require_once("home.php");
	
?>