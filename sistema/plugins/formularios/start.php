<?php
$pluginHome = "?plugin=formularios";
$pluginPasta = "plugins/formularios/";
$pluginTable = SUFIXO."formularios";

?>
</body>
<head>
	<script type="text/javascript">
		function mais_campos (id,max) {
			for(x=1;x<=max;x++) {
				if (document.getElementById(id+'A'+x).style.display=='none') {
					document.getElementById(id+'A'+x).style.display='block';
					break;
				}
			}
		}
	</script>
</head>
<body>
<h2>Formulários</h2>
<?php
if(isset($_GET['acoes'])){
	$gAcoes = $_GET['acoes'];
	require_once($gAcoes.'.php');
} else {
	require_once('home.php');
}
?>