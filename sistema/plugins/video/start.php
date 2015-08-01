<?php
$pluginHome = "?plugin=video";
$pluginPasta = "plugins/video/";
$pluginTable = SUFIXO."video";

?>
<style type="text/css" media="screen">
	@import "<?=$pluginPasta?>/css/album.css";
</style>
<span class="h1">Videos</span>
<?php
if(isset($_GET['acoes'])){
	$gAcoes = $_GET['acoes'];
	require_once($gAcoes.'.php');
} else {
	require_once('home.php');
}
?>