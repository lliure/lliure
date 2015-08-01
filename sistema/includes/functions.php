<?php
require_once("mLfunctions.php");

//	Efetuar login
function Login($login, $senha){
	$consulta = mysql_query("SELECT * FROM ".SUFIXO."admin WHERE Login = '$login' AND Senha = '$senha'") or die(mysql_error());
	if(mysql_num_rows($consulta) > 0){
		return true;
	}
	else{
		return false;
	}
}

//	REQUIRE PAGINA
function requirePage(){
	global $DadosLogado;
	
	if(!empty($DadosLogado)){
		if(isset($_GET['plugin'])){
			if(!empty($_GET['plugin'])){
				$get = $_GET['plugin'];
				$pagina = "plugins/$get/start.php";
			} else {
				$pagina = "paginas/plugins.php";
			}
		} elseif(isset($_GET['usuarios'])) {
			$pagina = "paginas/usuarios.php";
		} else {
			$pagina = "paginas/desktop.php";
		}
	} else {
		$pagina = "paginas/login.php";
	}

	return $pagina;
}

//	GERA MENSAGEM
function mensagemAviso($mensagem){
	$id = uniqid(time());
	
	return "<span id='".$id."' class='mensagem'>
				<span>$mensagem</span>
				<a href='javascript: void(0)' onclick=\"show_hide('".$id."')\" class='close'>X</a>
			</span>";
}

function loadPage($url, $tempo = 0){
	$tempo = ($tempo != 0?", '".$tempo."'":'');
	?><img src="erro.jpg" onerror="loadPage('<?=$url?>'<?=$tempo?>)" class="imge"><?php
}
	
function retornaLink($historico, $mods = 0){
	global $backReal;
	global $backNome ;
	
	if($mods === 'save'){
		array_pop($_SESSION['historicoNav']); // APAGA ESSA PÁGINA DO HISTÓRICO
		$historico = $_SESSION['historicoNav'];
	}
	
	$i = count($historico)-1;
	
	if($i > 0){
		$i--;
		$backReal = $historico[$i]."&goback";
		$backNome = "Voltar";
	} else {
		$backReal = "index.php";
		$backNome = "Voltar a área de trabalho";
	}
};

//
function in($var,$type = 'VALUE') {
	$in = '';
	foreach ($var as $k=>$v) {
		if($type=='VALUE')
			$in.="'".$v."',";
		else 
			$in.="'".$k."',";
	}
	$in = substr($in,0,-1);
	return $in;
}
// 
//JNAVIGATOR
require_once("jnav.php");

?>