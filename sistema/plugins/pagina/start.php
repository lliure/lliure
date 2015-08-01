<?php
$pluginHome = "?plugin=pagina";
$pluginPasta = "plugins/pagina/";
$pluginTable = SUFIXO."paginas";
?>

<h2>Administração de páginas</h2>
<?php
if(isset($_GET['acoes'])){
	$gAcoes = $_GET['acoes'];
	switch($gAcoes){
		case 'nova':
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