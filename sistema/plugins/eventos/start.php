<?php
$pluginHome = "?plugin=eventos";
$pluginPasta = "plugins/eventos/";
$pluginTable = SUFIXO."eventos";

?>
<span class="h1">Gereciado de eventos</span>
<?php
if(isset($_GET['acoes'])){
	$gAcoes = $_GET['acoes'];
	switch($gAcoes){
		case 'novo':
			require_once('new.php');
		break;
		
		case 'editar':
			require_once('step.php');
		break;
	}	
} else {
	require_once('home.php');
}
?>