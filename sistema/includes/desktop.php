<?php
require_once("../includes/conection.php"); 
require_once("functions.php"); 

$url = explode('?', $_SERVER['HTTP_REFERER']);
$url = $url['1'];

$nome = explode("&", $url);
$nome = explode("=", $nome['0']);
$nome = $nome['1'];
	header("Content-Type: text/html; charset=ISO-8859-1", true);
	
	$tabela = SUFIXO."desktop";
	$dados['nome'] = $nome;
	$dados['link'] = $url;
	$dados['imagem'] = "plugins/".$nome."/ico.png";
	
	//print_r($dados);
	
	mLinsert($tabela, $dados);	
?>
<img src="erro.jpg" onerror="alert('Página adicionada ao desktop com sucesso!')" class="imge"/>