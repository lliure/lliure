<?php
/**
*
* lliure CMS
*
* @versão 4.4.4
* @Desenvolvedor Jeison Frasson <contato@grapestudio.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
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
	
	if($mods === 'return')
		for($i = 0; $i < $modsQnt;$i++)
			array_pop($_SESSION['historicoNav']); // APAGA ESSA PÁGINA DO HISTÓRICO
	
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

// função que testa a segurança de uma página
function ll_securyt($app){
	/*
	No aquivo config.plg contido na pasta sys do aplicativo você insere a url de onde estára o arquivo de configuração de segurança, que normalmente estára em etc/nome_do_aplicativo/segur.ll
	
	Exemplo de um arquivo de segurança:
	
	<?xml version="1.0" encoding="iso-8859-1"?>
	<seguranca>
		<user> <p>banners</p> <grupo>$</grupo> </user>
		<user> <p>banners</p> <grupo>$</grupo> <id>$</id> </user>
	</seguranca>


	<sguranca> é o container onde estáram as diretrizes
	<user> é o nome do grupo que tera permissão para acessar a url
		para configurar coloque a chave do get depois o valor, caso possa acessar qualquer valor dentro deste get utilize '$' como valor
		exemplos para as urls:
		plugin=teste&p=usuarios			=	<user> <p>usuarios</p> </user>
		plugin=teste&p=modulos			=	<user> <p>modulos</p> </user>
		plugin=teste&p=usuarios&id=5	=	<user> <p>usuarios</p> <id>$</id> </user>
		plugin=teste&p=usuarios&id=10	=	<user> <p>usuarios</p> <id>$</id></user>
		plugin=teste					=	<user></user>
	como você pode verificar não é necessário setar o primeiro get, no caso o que aponta para o aplicativo em questão
	*/

	$grupo = $_SESSION['logado']['grupo'];
	if(($appConfig = @simplexml_load_file('etc/'.$app.'/seguranca.ll')) == true){
		
		$i = 0;
		if($appConfig->$grupo == 'public')
			return true;
		
		foreach($appConfig->$grupo as $urls){
			$permissao[$i] = array('plugin' => $_GET['plugin']);
			
			foreach((array) $urls as $indice => $valor)
				$permissao[$i][$indice] = ((!isset($valor) || $valor == '$') && isset($_GET[$indice]) ? $_GET[$indice] : $valor );
			
			$final = array_merge(array_diff($_GET, $permissao[$i]), array_diff($permissao[$i], $_GET));
				if(empty($final))
					return true;
			
			$i++;
		}
	}
	return false;
}

// função para testar permição do usuário
function ll_tsecuryt($grupo = null){
	
	/*
	Para usar basta puxar esta função dentro de um if() ela irá retornar true quando o usuário for desenvolverdor ou quando for especificado
	exemplos de utilização
	
	if(ll_tsecuryt()) // se estiver logado como desenvolvedor irá retornar true
	if(ll_tsecuryt('admin')) // se estiver logado como admin irá retornar true
	if(ll_tsecuryt('user')) // se estiver logado como user irá retornar true
	if(ll_tsecuryt(array('user', 'admin'))) // se estiver logado como user ou como admin irá retornar true
	*/
	
	$grupo_user = $_SESSION['logado']['grupo'];
	switch($grupo_user){
		case 'dev':
			return true;
		break;
		
		default:
			if((is_array($grupo_user) && in_array($grupo, $grupo_user)) || $grupo == $grupo_user)
				return true;
			else
				return false;
		break;
	}
}


//Converte parce xml em array
function xml2array ( $xmlObject, $out = array () ){
	foreach ( (array) $xmlObject as $index => $node )
		$out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

	return $out;
}

?>
