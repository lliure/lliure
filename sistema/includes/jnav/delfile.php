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
require_once("../functions.php"); 

$tabela = $_GET['tabela'];
$id = substr($_GET['id'], 4);

$alter['id']	= $id;

jf_delete($tabela, $alter);
?>
<img src="error.jpg" onerror="mLaviso('Item excluido com sucesso!', '1')" class="imge" alt="" /> 