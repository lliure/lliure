<?php
require_once("../../includes/conection.php"); 
require_once("../../includes/mLfunctions.php"); 

$id = $_GET['id'];

$dados[$_GET['nomecam']] = $_GET['arquivo'];

$alter['id'] = $id;

mLupdate(PREFIXO.$_GET['tabela'], $dados, $alter);
?>

<img src="erro.jpg" onerror="alteraFirst('<?php echo $_GET['arquivo']?>')" alt="" class="imge"/>
