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
require_once("../../includes/functions.php"); 
	
$tabela = PREFIXO.$_GET['tabela'];

$id = $_GET['id'];
$arquivo = $_GET['arquivo'];

$alter['id'] = $id;

@unlink($arquivo);

jf_delete($tabela, $alter);
?>
