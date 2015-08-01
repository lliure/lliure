<?php
	retornaLink($historico, 'save');
	$dados['nome'] = "Nova galeria";
	
	if(isset($_GET['id'])){
		$dados['id'] = $_GET['id'];
	}
	
	if(isset($_GET['gal'])){
		$dados['galeria'] = $_GET['gal']; 
	}
	
	$dados['tipo'] = '1'; 
	
	mLinsert($pluginTable, $dados);
	echo mensagemAviso("Nova galeria criada com sucesso.");
	
	require_once("home.php");
?>