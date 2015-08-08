<?php
/**
*
* lliure WAP
*
* @Versão 4.10.4
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Colaborador Rodrigo Dechen <rodrigo@grapestudio.com.br>
* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
require_once('etc/bdconf.php');
require_once('includes/functions.php');

$_ll['user'] = $_SESSION['logado'];


$_ll['css'] = array();
$_ll['js'] = array();

if(($_ll['conf'] = @simplexml_load_file('etc/llconf.ll')) == false)
	$_ll['conf'] = false;

$_ll['ling'] = ll_ling();


if(isset($_GET['app'])){
	
	
	if(!isset($_SESSION['logado'])) {
		$_SESSION['ll_url'] = jf_monta_link($_GET);
		header('location: paginas/login.php');
	}
	
	//require_once('includes/jf.funcoes.php');
	
		
	require_once("api/gerenciamento_de_api.php"); 
	$apigem = new api; 
	
	$_ll['app']['pagina'] = 'plugins/'.$_GET['app'].'/start.php';
	$_ll['app']['pasta'] = 'plugins/'.$_GET['app'].'/';
	
	$llAppHome = 'index.php?app='.$_GET['app'];
	$llAppOnServer = 'onserver.php?app='.$_GET['app'];
	$llAppPasta = $_ll['app']['pasta'];
	
	if(file_exists('plugins/'.$_GET['app'].'/header.php')){
		$_ll['app']['header'] = 'plugins/'.$_GET['app'].'/header.php';	
		require_once($_ll['app']['header']);
	}
	
	require_once('plugins/'.$_GET['app'].'/onserver.php');	
} else {
	header('location: index.php');
}
?>
