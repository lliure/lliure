<?php
/**
*
* lliure CMS
*
* @vers�o 4.4.4
* @Desenvolvedor Jeison Frasson <contato@grapestudio.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licen�a http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
require_once("../../etc/bdconf.php"); 
require_once("../../includes/jf.funcoes.php"); 

echo jf_update(PREFIXO.$_GET['tabela'], array($_GET['campo'] => $_GET['foto']), array('id' => $_GET['fk']));
?>