<?php
function carregaPage(){
	if(!empty($_GET)){
		if(isset($_GET['page'])){
			$page = "paginas/".$_GET['page'];
		} else {
		$getAtl = array_keys($_GET);
		$getAtl0 = $getAtl['0'];
		switch ($getAtl0) {
			case "home":
				$page = "paginas/home";		
			break;
			
			case 'imoveis':
				$page = "sistema/plugins/catalogo/exibe/categoria";
			break;
			case 'pesquisar':
				$page = "paginas/pesquisar";
			break;
			case 'contato':
				$_GET['formularios'] = '15';
				$getAtl0 = 'formularios';
				$page = "sistema/plugins/".$getAtl0;		
				$page = (file_exists($page)? $page."/exibe/start" : "sistema/includes/erro");
			break;


			default:
				$page = "sistema/plugins/".$getAtl0;		
				$page = (file_exists($page)? $page."/exibe/start" : "sistema/includes/erro");
			break;
		}

		}
	} else {
		$page = "paginas/home";
	}	
	
	return $page.".php";
}


function mLsubstrFull($texto, $final){
	if(strlen($texto) > $final){
		$final = strrpos(substr($texto, 0, $final), " ");
		$texto = substr($texto, 0 , $final)." ...";
	} 
	return $texto;
}

?>