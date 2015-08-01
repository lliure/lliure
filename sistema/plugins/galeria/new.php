<?php
	retornaLink($historico, 'save');
	$dados['nome'] = "Novo album";
	
	if(isset($_GET['id'])){
		$dados['id'] = $_GET['id'];
	}
	
	if(isset($_GET['gal'])){
		$dados['galeria'] = $_GET['gal']; 
	}
	
	$dados['tipo'] = 0;
	
	mLinsert($pluginTable, $dados);
	echo mensagemAviso("Novo album criado com sucesso.");
	
	require_once("home.php");
?>