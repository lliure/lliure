<?php
$pluginHome = "?plugin=noticias";
$pluginPasta = "plugins/noticias/";
$pluginTable = SUFIXO."noticias";

?>
<span class="h1">Noticias</span>
<?php
if(isset($_GET['acoes'])){
	$gAcoes = $_GET['acoes'];
	require_once($gAcoes.'.php');
} else {
	$pluginTable = $pluginTable."_categorias";
	require_once('home.php');
}
?>