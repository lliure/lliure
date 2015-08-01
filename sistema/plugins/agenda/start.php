<?php
$pluginHome = "?plugin=agenda";
$pluginPasta = "plugins/agenda/";
$pluginTable = SUFIXO."agenda";

?>
<h2>Agenda</h2>
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