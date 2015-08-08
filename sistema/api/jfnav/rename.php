<?php
/**
*
* API jfnav - Plugin CMS
*
* @Versão 4.7.1
* @Desenvolvedor Jeison Frasson <contato@grapestudio.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

require_once("../../etc/bdconf.php"); 
require_once("../../includes/functions.php"); 
header("Content-Type: text/html; charset=ISO-8859-1",true);
	
$tabela = $_GET['tabela'];

$_POST = jf_iconv('UTF-8', 'ISO-8859-1', $_POST) ;

$id = substr($_GET['id'], 4);

jf_update($tabela, $_POST, array('id' => $id));
?>

