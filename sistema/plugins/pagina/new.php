<?php
	retornaLink($historico, 'save');
	$tabela = SUFIXO."paginas";
	$dados['nome'] = "Nova p�gina";
	
	mLinsert($tabela, $dados);
	
	require_once("home.php");
?>