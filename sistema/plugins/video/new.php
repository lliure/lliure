<?php
	retornaLink($historico, 'save');
	$dados['nome'] = "Novo album";
	
	if(isset($_GET['id'])){
		$dados['id'] = $_GET['id'];
	}	
	
	mLinsert($pluginTable, $dados);
	echo mensagemAviso("Album criado com sucesso.");
	
	require_once("home.php");
	
?>