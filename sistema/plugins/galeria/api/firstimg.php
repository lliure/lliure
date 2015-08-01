<?php
	require_once("../../../../includes/conection.php"); 
	require_once("../../../includes/mLfunctions.php"); 
		
	$tabela =  $_GET['tabela'];

	$id = $_GET['id'];
	$arquivo = $_GET['arquivo'];
	
	$dados['firtPhoto'] = $arquivo;
	
	$alter['id']	= $id;
	
	mLupdate($tabela, $dados, $alter);
?>
<img src="erro.jpg" onerror="alteraFirst('<?=$arquivo?>')" alt="" class="imge"/>