<?php
/**
*
* lliure WAP
*
* @Versão 4.8.1
* @Desenvolvedor Jeison Frasson <contato@grapestudio.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

header("Content-Type: text/html; charset=ISO-8859-1", true);
require_once("../etc/bdconf.php"); 

$nome = "Novo usuario";
$executa = "INSERT INTO ".PREFIXO."admin (nome) values ('".$nome."')";
$query = mysql_query($executa);
?>

<script>
	jfnav_start();
</script>