<?php
	retornaLink($historico, 'save');
	$dados['nome'] = "Nome";
	$dados['descricao'] = "Descricao";
	
	
	$url = explode('?', $_POST['url']);
	$url = $url['1'];
	if(strstr($url, '&')){
		$url = explode('&', $url);
		foreach($url as $chave => $valor){
			if(strstr($valor, 'v=')){
				$url = $valor;
				break;
			}
		}
	} 
	$url = substr($url, 2);
	$dados['url'] = "http://www.youtube.com/v/".$url;
	

	$dados['album'] = $_GET['id'];
	
	mLinsert($pluginTable, $dados);
	echo mensagemAviso("O vídeo foi adicionado ao seu album.");
	
	require_once("album.php");
?>