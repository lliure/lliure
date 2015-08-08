<?php
/**
*
* lliure WAP
*
* @Versão 4.6.2
* @Desenvolvedor Jeison Frasson <contato@grapestudio.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

require_once("jf.funcoes.php"); 	// include no pacote JF funções

// Apelido de funcoes
function plg_historic($mods = null, $modsQnt = 1){
	return ll_historico($mods, $modsQnt);
}

function navig_historic(){
	return ll_historico('inicia');
}


///***///

	
function ll_historico($mods = null, $modsQnt = 1){
	global $backReal;
	global $backNome ;

	$retorno = true;
	
	switch($mods){
	case 'inicia':
		if(!empty($_GET)){
			$keyGet = array_keys($_GET);
			
			$pageatual = '?'.$_SERVER['QUERY_STRING'];
			if(isset($_SESSION['historicoNav']) && !empty($_SESSION['historicoNav'])){
				$count = count($_SESSION['historicoNav']);
				
				if($count > 1 && $pageatual == $_SESSION['historicoNav'][$count-2]){
					array_pop($_SESSION['historicoNav']);					
				} elseif($pageatual == $_SESSION['historicoNav'][$count-1]){
					// não faz nada caso a página atual for igual a última página visitada
				} else {
					$_SESSION['historicoNav'][] = $pageatual;
				}
			} else {				
				$_SESSION['historicoNav'][0] = $pageatual;
			}
			
			ll_historico();
			
		} else {
			if(isset($_SESSION['historicoNav'])){
				unset($_SESSION['historicoNav']);
			}		
		}

		return true;	
	break;

	case 'reinicia':
		$pageatual = '?'.$_SERVER['QUERY_STRING'];
		unset($_SESSION['historicoNav']);
		$_SESSION['historicoNav'][0] = $pageatual;
	break;
	
	case 'return':
		for($i = 0; $i < $modsQnt;$i++)
			array_pop($_SESSION['historicoNav']); // APAGA ESSA PÁGINA DO HISTÓRICO
	break;
	
	default:
	break;
	}

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
	
	return $retorno;
};

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

//função que retorna a linguagem nativa, caso não tenha nenhuma retorna false
function ll_ling(){
	global $llconf;	
	
	$retorno = false;
	
	if(isset($llconf->idiomas) && !empty($llconf->idiomas))
		$retorno = (string) $llconf->idiomas->nativo;
		
	return $retorno;
}

$ll_lista_idiomas = array(
	'pt_br' => 'Português (Brasil)',
	'en' => 'Inglês',
	'es' => 'Espanhol',
	'fr' => 'francês',
	'it' => 'italiano',
	'de' => 'alemão',
	'ar' => 'árabe',
	'zh' => 'chinês',
	'ja' => 'japonês',
	'ru' => 'russo',
	);

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
