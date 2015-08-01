<?php
session_start();
$conf = 2;
if ($conf == 1) {
	$hostname_conexao = "localhost";
	$username_conexao = "root";
	$password_conexao = "123";
	$banco_conexao = "denispoli";  
	
	define("SUFIXO", "sgs_");
} else {
	$hostname_conexao = "localhost";
	$username_conexao = "denispol_polis";
	$password_conexao = "102030";
	$banco_conexao = "denispol_politani";  
	
	define("SUFIXO", "sgs_");
}


$conexao = mysql_pconnect($hostname_conexao, $username_conexao, $password_conexao) or die("Site em manutenчуo");
	
mysql_select_db("$banco_conexao", $conexao);
?>