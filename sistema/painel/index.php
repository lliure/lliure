<?php
/**
*
* lliure WAP
*
* @Versão 4.9.1
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/


$pagina = 'home';
if(!empty($_GET['painel']) && file_exists('painel/'.$_GET['painel'].'.php'))
	$pagina = $_GET['painel'];
	
require_once('painel/'.$pagina.'.php');
?>
