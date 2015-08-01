<?php
$pluginHome = "?plugin=mapa";
$pluginPasta = "plugins/mapa/";
$pluginTable = SUFIXO."mapa";

?>
<h2>Mapas</h2>
<?php
if(isset($_GET['acoes'])){
	$gAcoes = $_GET['acoes'];
	require_once($gAcoes.'.php');
} else {
	require_once('home.php');
}
?>