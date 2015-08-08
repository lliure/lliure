<?php
session_start();

$hostname_conexao = "localhost";
$username_conexao = "root";
$password_conexao = "vertrigo";
$banco_conexao = "lliure_1";  

define("FILES", "../files");
define("SUFIXO", "plugin_");
define("SISTEMA", "sistema");

if(($conexao = @mysql_pconnect($hostname_conexao, $username_conexao, $password_conexao)) == false){
	echo "Falha na conexão: Servidor, login ou senha incorretos <br>";
}
if(@mysql_select_db("$banco_conexao", $conexao) == false){
	echo "Falha na conexão: base de dados não encontrada";
}
?>