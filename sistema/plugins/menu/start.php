<?php
$pluginHome = "?plugin=menu";
$pluginPasta = "plugins/menu/";
$pluginTable = SUFIXO.'menu';

require_once('functions.php');
?>
</body>
<head>

	<script type="text/javascript" src="<?=$pluginPasta?>js/script.js"></script>
	<style type="text/css" media="screen">
		@import "<?=$pluginPasta?>css/estilo.css";
	</style>
</head>

<body>
<span class="h1">Administração de menus</span>
<div class="interno">
<?php
if(isset($_GET['local'])){
	$gAcoes = $_GET['local'];
	require_once($gAcoes.'.php');
} else {
	require_once('home.php');
}
?>
</div>