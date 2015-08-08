<?php
/**
*
* Plugin CMS
*
* @versão 4.1.8
* @Desenvolvedor Jeison Frasson <contato@newsmade.com.br>
* @entre em contato com o desenvolvedor <contato@newsmade.com.br> http://www.newsmade.com.br/
* @licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

header("Content-Type: text/html; charset=ISO-8859-1", true);
require_once("../includes/conection.php"); 

$nome = "Novo usuario";
$executa = "INSERT INTO ".PREFIXO."admin (nome) values ('".$nome."')";
$query = mysql_query($executa);
?>

<script>
	jfnav_start();
</script>