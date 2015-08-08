<?php
require_once("conection.php"); 
require_once("functions.php"); 

$url = array_reverse($_SESSION['historicoNav']);
$url = $url[0];

if(isset($_GET['nome'])){
	$pasta = explode("&", $url);
	$pasta = explode("=", $pasta['0']);
	$pasta = $pasta['1'];
	
		header("Content-Type: text/html; charset=ISO-8859-1", true);
		
		$tabela = PREFIXO."desktop";
		$dados['nome'] = $_GET['nome'];
		$dados['link'] = $url;
		$dados['imagem'] = "plugins/".$pasta."/sys/ico.png";
		
		//print_r($dados);
		
		mLinsert($tabela, $dados);
	?>
	<img src="erro.jpg" onerror="mLaviso('A página <?php echo $_GET['nome']?> foi adicionada com sucesso ao seu desktop!')" class="imge"/>
	<?php
} else {
	?>
	<img src="erro.jpg" onerror="nomeDaPagina()" class="imge"/>
	<?php
}
?>


