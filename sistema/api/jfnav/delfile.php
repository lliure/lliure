<?php
/**
*
* API jfnav - Plugin CMS
*
* @Versão 4.8.1
* @Desenvolvedor Jeison Frasson <contato@grapestudio.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
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
