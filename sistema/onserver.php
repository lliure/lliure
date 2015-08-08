<?php
/**
*
* lliure WAP
*
* @Versão 4.9.1
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Colaborador Rodrigo Dechen <rodrigo@grapestudio.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if(isset($_GET['app'])){
	require_once('etc/bdconf.php');
	
	if(!isset($_SESSION['logado'])) {
		$_SESSION['ll_url'] = jf_monta_link($_GET);
		header('location: paginas/login.php');
	}
	
	require_once('includes/jf.funcoes.php');
	require_once("includes/gerenciamento_api.php"); 
	
	$llAppHome = 'index.php?app='.$_GET['app'];
	$llAppOnServer = 'onserver.php?app='.$_GET['app'];
	$llAppPasta = 'plugins/'.$_GET['app'].'/';
	
	require_once('plugins/'.$_GET['app'].'/onserver.php');	
} else {
	header('location: index.php');
}
?>