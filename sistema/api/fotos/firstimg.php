<?php
/**
*
* lliure WAP
*
* @Vers�o 4.9.1
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licen�a http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
require_once("../../etc/bdconf.php"); 
require_once("../../includes/jf.funcoes.php"); 

jf_update(PREFIXO.$_GET['tabela'], array($_GET['campo'] => $_GET['foto']), array('id' => $_GET['fk']));
?>
