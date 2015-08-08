<?php
/**
*
* API jfnav - Plugin CMS
*
* @versão 4.4.4
* @Desenvolvedor Jeison Frasson <contato@grapestudio.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

require_once("../../etc/bdconf.php"); 
require_once("../../includes/functions.php"); 
header("Content-Type: text/html; charset=ISO-8859-1",true);
	
$tabela = $_GET['tabela'];

$dados['nome'] 	=  iconv('UTF-8', 'ISO-8859-1', $_POST['nome']) ;

$id = substr($_GET['id'], 4);

$alter['id'] = $id;


jf_update($tabela, $dados, $alter);
?>

