<?php
session_start();

$hostname_conexao = "localhost";
$username_conexao = "root";
$password_conexao = "vertrigo";
$banco_conexao = "logquim";  

define("PREFIXO", "plugin_");
define("SISTEMA", "sistema");


$conexao = mysql_pconnect($hostname_conexao, $username_conexao, $password_conexao) or die("Site em manutenção");
	
mysql_select_db("$banco_conexao", $conexao);

$DadosLogado  = (isset($_SESSION['logado'])? $_SESSION['logado'] : '');

$extendeTopPlugin = '<style type="text/css">#conteudo{background: url("imagens/layout/fundo_branco.png") repeat-x;}</style>';
?>