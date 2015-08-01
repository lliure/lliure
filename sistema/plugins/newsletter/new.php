<?php
	retornaLink($historico, 'save');
	$tabela = SUFIXO."paginas";
	$dados['nome'] = "Nova página";
	
	mLinsert($tabela, $dados);
	
	require_once("home.php");
?>