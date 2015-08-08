<?php
/**
*
* lliure CMS
*
* @Versão 4.5.2
* @Desenvolvedor Jeison Frasson <contato@grapestudio.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
header("Content-Type: text/html; charset=ISO-8859-1", true);
require_once("conection.php"); 
require_once("functions.php"); 
	
$url = array_reverse($_SESSION['historicoNav']);
$url = $url[0];

$pasta = explode("&", $url);
$pasta = explode("=", $pasta['0']);
$pasta = $pasta['1'];

$tabela = PREFIXO."desktop";
$dados['nome'] = $_GET['nome'];
$dados['link'] = $url;
$dados['imagem'] = "plugins/".$pasta."/sys/ico.png";

jf_insert($tabela, $dados);
?>

<script type="text/javascript">
	jfAlert('<?php echo 'A página <strong>'.$_GET['nome'].'</strong> foi adicionada com sucesso ao seu desktop!'?>', 0.7);
</script>