<?php
/**
*
* API jfnav - Plugin CMS
*
* @versão 4.3.3
* @Desenvolvedor Jeison Frasson <contato@newsmade.com.br>
* @entre em contato com o desenvolvedor <contato@newsmade.com.br> http://www.newsmade.com.br/
* @licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

require_once("../../etc/bdconf.php"); 
require_once("../../includes/functions.php"); 

$tabela = $_GET['tabela'];
$id = substr($_GET['id'], 4);

$alter['id']	= $id;

jf_delete($tabela, $alter);
?>

<script type="text/javascript">
	jfAlert('Item excluido com sucesso!', 0.7);
</script>
