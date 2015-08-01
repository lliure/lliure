<?php
	retornaLink($_SESSION['historicoNav'], 'save');
	
	$pluginTable = $pluginTable."_categorias";
	
	$dados['nome'] = "Novo noticiario";
	$dados['titulo'] = "Noticias";
	
	if(isset($_GET['id'])){
		$dados['id'] = $_GET['id'];
	}	
	
	mLinsert($pluginTable, $dados);
	echo mensagemAviso("Novo noticiario criado com sucesso.");
	
	require_once("home.php");
?>