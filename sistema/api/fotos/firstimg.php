<?php
/**
*
* Plugin CMS
*
* @versão 4.0.1
* @Desenvolvedor Jeison Frasson <contato@newsmade.com.br>
* @entre em contato com o desenvolvedor <contato@newsmade.com.br> http://www.newsmade.com.br/
* @licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
require_once("../../includes/conection.php"); 
require_once("../../includes/jf.funcoes.php"); 

echo jf_update(PREFIXO.$_GET['tabela'], array($_GET['campo'] => $_GET['foto']), array('id' => $_GET['fk']));
?>