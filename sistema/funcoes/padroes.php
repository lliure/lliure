<?php
function carregaPage(){
	if(!empty($_GET)){
		if(isset($_GET['page'])){
			$page = "paginas/".$_GET['page'];
		} else {
		$getAtl = array_keys($_GET);
		$getAtl0 = $getAtl['0'];
		$page = SISTEMA."/plugins/".$getAtl0;		
			
		$page = (file_exists($page)? $page."/exibe/start" : SISTEMA."/includes/erro");
		}
	} else {
		$page = "paginas/home.php";
		if(file_exists($page)){
			$page = "paginas/home";
		} else {
			$page = SISTEMA."/plugins/pagina/exibe/start";
		}
	}	
	
	return $page.".php";
}

function mLsubstrFull($texto, $final){
	$texto = strip_tags($texto);
	if(strlen($texto) > $final){
		$final = strrpos(substr($texto, 0, $final), " ");
		$texto = substr($texto, 0 , $final)." ...";
	} 
	return $texto;
}

?>