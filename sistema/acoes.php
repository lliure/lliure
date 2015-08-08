<?php
if($_GET){
	require_once("includes/conection.php"); 
	require_once("includes/mLfunctions.php"); 
	
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