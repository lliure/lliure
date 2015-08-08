<?php
/**
*
* lliure WAP
*
* @Vers�o 4.6.2
* @Desenvolvedor Jeison Frasson <contato@grapestudio.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licen�a http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

require_once("jf.funcoes.php"); 	// include no pacote JF fun��es

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
					// n�o faz nada caso a p�gina atual for igual a �ltima p�gina visitada
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
			array_pop($_SESSION['historicoNav']); // APAGA ESSA P�GINA DO HIST�RICO
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
		$backNome = "Voltar � �rea de trabalho";
	}
	
	return $retorno;
};

// fun��o que testa a seguran�a de uma p�gina
function ll_securyt($app){
	/*
	No aquivo config.plg contido na pasta sys do aplicativo voc� insere a url de onde est�ra o arquivo de configura��o de seguran�a, que normalmente est�ra em etc/nome_do_aplicativo/segur.ll
	
	Exemplo de um arquivo de seguran�a:
	
	<?xml version="1.0" encoding="iso-8859-1"?>
	<seguranca>
		<user> <p>banners</p> <grupo>$</grupo> </user>
		<user> <p>banners</p> <grupo>$</grupo> <id>$</id> </user>
	</seguranca>


	<sguranca> � o container onde est�ram as diretrizes
	<user> � o nome do grupo que tera permiss�o para acessar a url
		para configurar coloque a chave do get depois o valor, caso possa acessar qualquer valor dentro deste get utilize '$' como valor
		exemplos para as urls:
		plugin=teste&p=usuarios			=	<user> <p>usuarios</p> </user>
		plugin=teste&p=modulos			=	<user> <p>modulos</p> </user>
		plugin=teste&p=usuarios&id=5	=	<user> <p>usuarios</p> <id>$</id> </user>
		plugin=teste&p=usuarios&id=10	=	<user> <p>usuarios</p> <id>$</id></user>
		plugin=teste					=	<user></user>
	como voc� pode verificar n�o � necess�rio setar o primeiro get, no caso o que aponta para o aplicativo em quest�o
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

// fun��o para testar permi��o do usu�rio
function ll_tsecuryt($grupo = null){
	
	/*
	Para usar basta puxar esta fun��o dentro de um if() ela ir� retornar true quando o usu�rio for desenvolverdor ou quando for especificado
	exemplos de utiliza��o
	
	if(ll_tsecuryt()) // se estiver logado como desenvolvedor ir� retornar true
	if(ll_tsecuryt('admin')) // se estiver logado como admin ir� retornar true
	if(ll_tsecuryt('user')) // se estiver logado como user ir� retornar true
	if(ll_tsecuryt(array('user', 'admin'))) // se estiver logado como user ou como admin ir� retornar true
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

//fun��o que retorna a linguagem nativa, caso n�o tenha nenhuma retorna false
function ll_ling(){
	global $llconf;	
	
	$retorno = false;
	
	if(isset($llconf->idiomas) && !empty($llconf->idiomas))
		$retorno = (string) $llconf->idiomas->nativo;
		
	return $retorno;
}

$ll_lista_idiomas = array(
	'pt_br' => 'Portugu�s (Brasil)',
	'en' => 'Ingl�s',
	'es' => 'Espanhol',
	'fr' => 'franc�s',
	'it' => 'italiano',
	'de' => 'alem�o',
	'ar' => '�rabe',
	'zh' => 'chin�s',
	'ja' => 'japon�s',
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
