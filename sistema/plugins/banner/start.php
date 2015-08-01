<?php
$pluginHome = "?plugin=banner";
$pluginPasta = "plugins/banner/";
$pluginTable = SUFIXO."banner";

?>
<span class="h1">Banners</span>
<?php
$banners = array(
		'1' => '120x60', //horizontal
		'2' => '468x60',
		'3' => '234x60',
		'4' => '88x31',
		'5' => '180x50', 
		'6' => '120x240', // vertical
		'7' => '150x300',
		'8' => '120x600',
		'9' => '160x600',
		);

if(isset($_GET['acoes'])){
	$gAcoes = $_GET['acoes'];
	require_once($gAcoes.'.php');
} else {
	require_once('home.php');
}
?>