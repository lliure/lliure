<?php
	retornaLink($historico, 'save');
	
	$oQueCria = (!empty($oQueCria)?$oQueCria:'defalut');
	switch($oQueCria){
	case 'cat':
		$dados = array(
			'nome' 		=> 'Nova categoria',
			'idMe'		=> $categoria,
			'categoria' => $idMenu
		);
	break;
	
	case 'link':

		$dados = array(
			'nome' 		=> 'Novo link',
			'idMe'		=> $categoria,
			'categoria' => $idMenu,
			'tipo' => 'new'
		);
	break;
	
	default:
		$consulta = "select idMe from ".$pluginTable." where categoria is NULL order by idMe desc";
		$query = mysql_fetch_array(mysql_query($consulta));
		
		$sobreCat = (!empty($query['0'])?$query['0']:'0');

		$categoria = autoIncrementLetter($sobreCat);
		
		$dados = array(
			'nome' => 'Novo menu',
			'idMe' => $categoria
			);
	break;
	}
	
	mLinsert($pluginTable, $dados);
	
?>