<?php
/**
*
* * Jfnav
*
* @versão 4.1.8
* @Desenvolvedor Jeison Frasson <contato@newsmade.com.br>
* @entre em contato com o desenvolvedor <contato@newsmade.com.br> http://www.newsmade.com.br/
* @licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

require_once("../../includes/conection.php"); 
require_once("../../includes/functions.php"); 
header("Content-Type: text/html; charset=ISO-8859-1",true);
	
$tabela = $_GET['tabela'];

$dados['nome'] 	=  iconv('UTF-8', 'ISO-8859-1', $_POST['nome']) ;

$id = substr($_GET['id'], 4);

$alter['id'] = $id;


jf_update($tabela, $dados, $alter);
?>

