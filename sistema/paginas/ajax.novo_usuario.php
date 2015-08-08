<?php
require_once("../includes/conection.php"); 
require_once("../includes/jnav.php"); 
header("Content-Type: text/html; charset=ISO-8859-1", true);

$nome = "Novo usuario";
$executa = "INSERT INTO ".PREFIXO."admin (nome) values ('".$nome."')";
$ondblclick = "?usuarios=";
$icone = "imagens/layout/user.png";

$query = mysql_query($executa);
$ultimo_id = mysql_insert_id();

$conteudo = jNavigatorInner($ultimo_id, $ondblclick, $icone, $nome);
?>

<script>
	$('#bodyhome').append('<?php echo $conteudo?>');
</script>