<?php
/**
*
* lliure WAP
*
* @Vers�o 6.0
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br/
* @Licen�a http://opensource.org/licenses/gpl-license.php GNU Public License
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
