<?php
/**
*
* lliure WAP
*
* @Vers�o 4.10.4
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br/
* @Licen�a http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

header("Content-Type: text/html; charset=ISO-8859-1", true);
require_once("../etc/bdconf.php"); 

$nome = "Novo usuario";
$executa = "INSERT INTO ".PREFIXO."admin (nome) values ('".$nome."')";
$query = mysql_query($executa);
?>