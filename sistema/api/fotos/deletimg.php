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

require_once("../../etc/bdconf.php"); 
require_once("../../includes/functions.php"); 
	
$tabela = PREFIXO.$_GET['tabela'].'_fotos';

$id = $_GET['id'];
$arquivo = $_GET['arquivo'];

$alter['id'] = $id;

@unlink($arquivo);

mLdelete($tabela, $alter);
?>
