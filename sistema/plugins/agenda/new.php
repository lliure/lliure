<?php
	retornaLink($historico, 'save');
	$dados['nome'] = "Novo compromisso ";
	
	if(isset($_GET['id'])){
		$dados['id'] = $_GET['id'];
	}	
	
	mLinsert($pluginTable, $dados);
	echo mensagemAviso("Novo compromisso  criado com sucesso.");
	
	require_once("home.php");
	
?>