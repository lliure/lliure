<?php
/**
*
* Plugin CMS
*
* @versão 4.3.3
* @Desenvolvedor Jeison Frasson <contato@newsmade.com.br>
* @entre em contato com o desenvolvedor <contato@newsmade.com.br> http://www.newsmade.com.br/
* @licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if($_GET){
	require_once("etc/bdconf.php"); 
	require_once("includes/jf.funcoes.php"); 
	
	$acao = array_keys($_GET);
	$acao = $acao[0];
	switch($acao){
		case 'logout':
			session_destroy();
			header('location: paginas/login.php');
		break;
		
		default:
		break;
	}
}
?>
