<?php
$pluginHome = "?plugin=cidades";
$pluginPasta = "plugins/cidades/";
?>
<h2>Cidades / Bairros</h2>
<?php
if(isset($_GET['acoes'])){
	if (isset($_GET['editar'])) {
		if ($_GET['acoes'] == 'categorias') {
			require_once('editarcat.php');
		} elseif ($_GET['acoes'] == 'produtos') {
			require_once('editarprod.php');
		}
		
	} elseif (isset($_GET['del'])) {
		require_once('apagar.php');
	} else {
		$gAcoes = $_GET['acoes'];
		switch($gAcoes){	
			case 'novacat':
				require_once('novacat.php');
			break;
			case 'novoprod':
				require_once('editarprod.php');
			break;
			
			case 'categorias':
				require_once('categorias.php');
			break;
			
			case 'produtos':
				require_once('produtos.php');
			break;
	
		}
	}	
} else {
	require_once('home.php');
}
?>