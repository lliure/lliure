<?php
$pluginHome = "?plugin=galeria";
$pluginPasta = "plugins/galeria/";
$pluginTable = SUFIXO."galeria";

if(isset($_GET['gal'])){
	$filtro = " where galeria = '".$_GET['gal']."'";
	$linkGal = "&amp;gal=".$_GET['gal'];
} else {
	$filtro = " where galeria is NULL";
	$linkGal = "";

}

?>
<h2>Galeria de fotos</h2>
<?php
if(isset($_GET['acoes'])){
	$gAcoes = $_GET['acoes'];
	switch($gAcoes){
		case 'novogal':
			require_once('newgal.php');
		break;		
		
		case 'nova':
			require_once('new.php');
		break;
		
		case 'editar':
			require_once('step.php');
		break;
		
		case 'rfotos':
			require_once('api/refotos.php');
		break;
	}	
} else {
	require_once('home.php');
}
?>