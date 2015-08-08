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
