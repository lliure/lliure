<?php
/**
*
* Plugin CMS
*
* @versão 4.2.7
* @Desenvolvedor Jeison Frasson <contato@newsmade.com.br>
* @entre em contato com o desenvolvedor <contato@newsmade.com.br> http://www.newsmade.com.br/
* @licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

require_once("jf.funcoes.php"); 	// include no pacote JF funções

/*
//	GERA MENSAGEM
function mensagemAviso($mensagem){
	$id = uniqid(time());
	
	return "<div id='".$id."' class='mensagem'>
				<span>$mensagem</span>
				<a href='javascript: void(0)' onclick=\"show_hide('".$id."')\" class='close'>X</a>
			</div>";
}
/*
function alert($mensagem, $tempo = null){
		echo '<img src="error.jpg" onerror="mLaviso(\''.$mensagem.'\' '.(!is_null($tempo) ? '\''.$tempo.'\'' : '').')" class="imge" alt="" />';
	}*/
/*
function loadPage($url, $tempo = 0){
	$tempo = ($tempo != 0?", '".$tempo."'":'');
	?><img src="erro.jpg" onerror="loadPage('<?php echo $url?>'<?php echo $tempo?>)" class="imge"><?php
}
*/
/*
if(isset($_SESSION['historicoNav'])){
	print_r($_SESSION['historicoNav']);
	die();
}
*/
//print_r($_SESSION['historicoNav']);
function navig_historic(){
	if(!empty($_GET)){
		$keyGet = array_keys($_GET);
		if($keyGet['0'] == 'plugin'){	
			$pageatual = '?'.$_SERVER['QUERY_STRING'];
			if(isset($_SESSION['historicoNav'])){				
				$count = count($_SESSION['historicoNav']);
				if($count > 2 && $pageatual == $_SESSION['historicoNav'][$count-2]){
					array_pop($_SESSION['historicoNav']);
				} elseif(isset($keyGet[1])){
					if(in_array($pageatual, $_SESSION['historicoNav']) == false){
						$_SESSION['historicoNav'][] = $pageatual;
					}
				} else {
					unset($_SESSION['historicoNav']);
					$_SESSION['historicoNav'][0] = $pageatual;
				}
				$historico = $_SESSION['historicoNav'];
			} else {				
				$_SESSION['historicoNav'][0] = $pageatual;
			}
			
			plg_historic();
		}
	} else {
		if(isset($_SESSION['historicoNav'])){
			unset($_SESSION['historicoNav']);
		}		
	}
}
	
function plg_historic($mods = null, $modsQnt = 1){
	global $backReal;
	global $backNome ;
	/*
	if($mods === 'return')
		for($i = 0; $i < $modsQnt;$i++)
			array_pop($_SESSION['historicoNav']); // APAGA ESSA PÁGINA DO HISTÓRICO
		
	*/
	$historico = $_SESSION['historicoNav'];
	$i = count($historico)-1;
	
	if($i > 0){
		$i--;
		$backReal = $historico[$i];
		$backNome = "Voltar";
	} else {
	
		$backReal = "index.php";
		$backNome = "Voltar à área de trabalho";
	}
};

// in
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

?>