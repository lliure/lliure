<?php
/**
*
* lliure CMS
*
* @Versão 4.5.2
* @Desenvolvedor Jeison Frasson <contato@grapestudio.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/*******************************	VARIAVEIS	*/
$diasdasemana = array ("Domingo", "Segunda-Feira", "Terça-Feira","Quarta-Feira","Quinta-Feira","Sexta-Feira", "Sábado",);
$meses = array("0","Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");


/*******************************	APELIDO DE FUNÇÕES	*/
//	ALTERA DATA PARA UNIX
function mlDUnix($data){
	return jf_dunix($data);
}

//	funcão substr melhorada
function mLSubstr($texto, $final = 100){
	return jf_substr($texto, $final);
}

//	funcão de anti injection
function mLAntiInjection($sql){
	return jf_anti_injection($sql);
}


function mLinsert($tabela, $dados){
	return jf_insert($tabela, $dados);
}

function mLdelete($tabela, $alter){
	return jf_delete($tabela, $alter);
}

function mLupdate($tabela, $dados, $alter, $mod = null){
	return jf_update($tabela, $dados, $alter, $mod);
}

/*******************************	FUNÇÕES	*/

// Alternativa para file_get_contents()
function jf_file_get_contents($url, $timeout = 10) {
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$file_contents = curl_exec($ch);
	curl_close($ch);
	return ($file_contents) ? $file_contents : FALSE;
}

//	Anti injection
function jf_anti_injection($sql) {
	$sql = mysql_real_escape_string($sql);
	return $sql;
}

// FUNÇÃO PARA TRABALHAR COM TOKEN
function jf_token($caso){
	switch($caso){
		default:
			if(isset($_SESSION['plg_token']) && $_SESSION['plg_token'] == $caso)
				return true;
			else
				return false;
			
		break;
		
		case 'exibe':
			if(isset($_SESSION['plg_token']))
				return $_SESSION['plg_token'];
			else
				return false;
		break;
		
		case 'novo':
			$token = rand();
			$_SESSION['plg_token'] = $token;
			return $token;
		break;
	}
}
	
	
//	GERA MENSAGEM	
function mlAviso($mensagem, $close = 1){
	$id = uniqid(time());
	return "<span id='".$id."' class='mensagem'>
				<span>$mensagem</span>
				".($close != 0?"<a href='javascript: void(0)' onclick=\"show_hide('".$id."')\" class='close'>X</a>":'')."
			</span>";
}

function jf_insert($tabela, $dados){
	/*
	//Descrição
	jf_insert(string $tabela, array $dados)
	monta e execulta uma query de insert em mysql	
		
	// Parametros
	$table
	nome da tabela que estará sendo feito o insert
	
	$dados
	Dados que serão inseridos na tabela em forma de array
		
	$dados = array(
			'coluna' 	=>	'dado',
			'coluna2' 	=>	'dado2'
			);	

	// Retorno
	retorna a query montada para conferência, porem ela será execultada 
	retorna também a variável  $jf_ultimo_id que é o valor auto-increment retornado neste insert 
	*/
	
	$valores = '';
	$colunas = '';
	foreach($dados as $chaves => $valor){
		$valor = ($valor != 'NULL' ? '"'.addslashes($valor).'"' : 'NULL');
		$valores .= (empty($valores)? '' : ',').$valor;
		$colunas .= (empty($colunas)? '' : ', ').$chaves;
	}
	
	$executa = "INSERT INTO $tabela ($colunas) values ($valores)";
	if(mysql_query($executa) != false){
		global $ml_ultmo_id;
		global $jf_ultimo_id;
		
		$jf_ultimo_id = mysql_insert_id();
		$ml_ultmo_id = $jf_ultimo_id;
	} else{
		echo mysql_error();
		$executa = false;
	}
	
	return $executa;
}

function jf_update($tabela, $dados, $alter, $mod = null){

	/* EXPLICANDO *********************************
	$table = "nomedatabela";
	$dados = array(
			'coluna' 	=>	'dados',
			'coluna2' 	=>	'dados2'
			);
			
	$alter = $alter['coluna'] = "Valor";

	$mod = ">" ou "<" ou "=" caso nenhum o padrão é "like"
	
	para setar um valor como NULL é só enviar NULL, valores vazios não faram parte da query
	*/

 	$valores = '';
	foreach($dados as $chaves => $valor){
		$valor = ($valor != 'NULL' ? '"'.addslashes($valor).'"' : 'NULL');
		$valores .= (empty($valores)?' ':', ').$chaves.' = '.$valor;
	}
	
	$int = array_keys($alter);
	$int = $int[0];
	$intv = $alter[$int];
	
	is_null($mod) ? $mod = "=" : $mod = "$mod" ;
	
	$executa = "UPDATE $tabela Set $valores where $int $mod '$intv'";
	$query = mysql_query($executa);
	
	return $executa;
}

// PARA DELETE
function jf_delete($tabela, $alter){
	
	$int = array_keys($alter);
	$int = $int[0];
	$intv = $alter[$int];
	
	
	$executa = "DELETE FROM $tabela where $int = '$intv'";
	$query = mysql_query($executa);
	
	return $executa;
}

function mlLimpaacento($texto){
	$texto = ereg_replace('[ÁÀÂÃ]', 'A', $texto);
	$texto = ereg_replace("[áàâãª]","a",$texto);
	$texto = ereg_replace("[ÉÈÊ]","E",$texto);
	$texto = ereg_replace("[éèê]","e",$texto);
	$texto = ereg_replace("[íìîï]","i",$texto);
	$texto = ereg_replace("[ÍÌÎÏ]","I",$texto);
	$texto = ereg_replace("[ÓÒÔÕ]","O",$texto);
	$texto = ereg_replace("[óòôõº]","o",$texto);
	$texto = ereg_replace("[ÚÙÛ]","U",$texto);
	$texto = ereg_replace("[úùû]","u",$texto);
	$texto = str_replace("Ç","C",$texto);
	$texto = str_replace("ç","c",$texto);
	$texto = str_replace(" ","-",$texto);
	$texto = str_replace("'", "", $texto);		
	$texto = str_replace('"', "", $texto);		
	return($texto);
}


//	Gerencia o array GET, onde retira o $needle (pode ser um array) caso exista em GET e monta em modo de link
function jf_monta_link($haystack, $needle = null, $amigavel = false){
	if($needle == 'URL_AMIGAVEL')
		$amigavel = true;	

	if(!is_null($needle) && $needle != 'URL_AMIGAVEL') {
		if(is_array($needle) == false){
			unset($haystack[$needle]);
		} else {
			foreach($needle as $chave => $vale){
				unset($haystack[$vale]);
			}
		}
	}
	
	$keys = array_keys($haystack);
	$i = 1;
	$final = '';
	
	if($amigavel == true){
		foreach($keys as $chave => $val){
			$final .= ($i != 1?'/':'').(is_numeric($val) || $val == 'p'?'':$val.'=').$haystack[$val];
			$i++;
		}
	} else {		
		foreach($keys as $chave => $val){
			$final .= ($i != 1?"&":'').$val."=".$haystack[$val];
			$i++;
		}		
		$final = "?".$final;
	}
	
	return $final;
}

function jf_substr($texto, $final = 100){
	if(strlen($texto) > $final){
		$final = strrpos(substr($texto, 0, $final), " ");
		$texto = substr($texto, 0 , $final)." ...";
	} 
	return $texto;
}

//	Gerencia multiplos botoes submit em um form
function jf_form_actions(){
	/*
	Para usar
	switch (jf_form_actions('arg1', 'arg2', ..., 'argN')){
		case 'arg1':
		break;
		
		case 'arg2':
		break;
		
		...
		
		case 'argN':
		break
	}	
	*/

    $params = func_get_args();
    
    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            unset($_POST[$name]);
			return $name;
        }
    }
}

//	Arredondamento de Inteiros
function jf_roundint($val, $arredondaPor = 10){
	/*
	//Descrição
	jf_roundint(string $val [, int $arredondaPor])
	Arredonda um valor para inteiro para um valor sequencial inteiro	
	
	//Exemplos
	jf_roundint(7); 	// retorna "10"
	jf_roundint(54, 5);	// retorna "55"
	jf_roundint(38, 5);	// retorna "40"
	jf_roundint(38, 7);	// retorna "35"
	*/
	
	$resto = $val%$arredondaPor;

	if($resto <= ($arredondaPor/2))
		$resultado = $val-$resto;
	else 
		$resultado = $val-$resto+$arredondaPor;	
	
	return $resultado;
}

function jf_dunix($dataEnt){
	$diario = explode(' ', $dataEnt);

	if(isset($diario[1])){
		$hora = explode(':', $diario[1]);
		
		$data['hora'] = $hora[0];
		$data['minuto'] = $hora[1];
		$data['second'] = (isset($hora[2])? $hora[2] : 0);
	} else {
		$data['hora'] = 0;
		$data['minuto'] = 0;
		$data['second'] = 0;
	}
	
	$diario = explode('/', $diario[0]);
	
	$data['dia'] = $diario[0];
	$data['mes'] = $diario[1];
	
	if(isset($diario[2])){
		$data['ano'] = $diario[2];
	} else {
		$hoje = time();
		$ano = date('Y');
		
		$anos[0] = array((jf_dunix($data['dia'].'/'.$data['mes'].'/'.($ano-1)) - $hoje)*-1 , $ano-1);
		$anos[1] = array(jf_dunix($data['dia'].'/'.$data['mes'].'/'.$ano)  - $hoje, $ano);
		$anos[2] = array(jf_dunix($data['dia'].'/'.$data['mes'].'/'.($ano+1))  - $hoje, $ano+1);
		
		$minimo = 0;
		foreach($anos as $chave => $valor)
			if($anos[$minimo][0] > $valor[0])
				$minimo = $chave;
				
		$data['ano'] = $anos[$minimo][1];
	}
	
	$formata = mktime  ($data['hora'], $data['minuto'], $data['second'], $data['mes'], $data['dia'], $data['ano']);
	return $formata;
}

//	Função iconv formulada para array
function jf_iconv($in_charset, $out_charset, $arr){ 
	

	if (!is_array($arr)){
		return iconv($in_charset, $out_charset, $arr);
	}
	
	$ret = $arr;
	function array_iconv(&$val, $key, $userdata){
		$val = iconv($userdata[0], $userdata[1], $val);
	}
	array_walk_recursive($ret, "array_iconv", array($in_charset, $out_charset));
	return $ret;
}


function jf_urlformat($texto){
	$texto = mb_strtolower($texto);
	$texto = preg_replace("/[áàâãª]/","a",$texto);
	$texto = preg_replace("/[éèê]/","e",$texto);
	$texto = preg_replace("/[íìîï]/","i",$texto);
	$texto = preg_replace("/[óòôõº]/","o",$texto);
	$texto = preg_replace("/[úùû]/","u",$texto);
	$texto = str_replace("ç","c",$texto);
	$texto = preg_replace("/[^ a-z 0-9 \t _ \/ -]/", "", $texto);	
	$texto = str_replace(" ","-",$texto);
	return($texto);
}

function jf_stradd($var, $caracter, $lim){
	$tamanho = strlen($var);
	$nova = '';
	if($tamanho > $lim){	
		$quebra = $tamanho/$lim;
		$ini = 0;
		$fim = $lim;
	
		for($i=0; $i <= intval($quebra); $i++){
			if($i == intval($quebra))
				$nova.= substr($var, $ini, $lim);
			else
				$nova.= substr($var, $ini, $lim).$caracter;
		
			$ini = $fim;
			$fim = $fim+$lim;
		}
	
		return $nova;
		
	} else {
		return $var;
	}
}


//	CLASSE DE EXTENÇÃO PARA TRATAR ELEMENTOS XML
class jf_xml extends SimpleXMLElement {
	//FUNÇÃO PARA CONVERTER O XML EM STRING E ADICIONAR TABULAÇÕES
	public function jf_pretty_xml(){
		$xmlArray = explode("\n", preg_replace('/>\s*</', ">\n<", $this->asXML()));
		$pretty = array();		
		$indent = 0;
		
		// Retira o primeiro atributo para não colocar tabulação
		if (count($xmlArray) && preg_match('/^<\?\s*xml/', $xmlArray[0]))
			$pretty[] = array_shift($xmlArray);
				

		foreach ($xmlArray as $el) {
			if (preg_match('/^<([\w])+[^>\/]*>$/U', $el)) {
				// opening tag, increase indent
				$pretty[] = str_repeat("\t", $indent) . $el;
				$indent += 1;
			} else {
				if (preg_match('/^<\/.+>$/', $el)) {
					// closing tag, decrease indent
					$indent -= 1;
				}
				
				$pretty[] = str_repeat("\t", $indent) . $el;
			}
		}
		return implode("\n", $pretty);
	}


	// FUNÇÃO PARA CONVERTER ARRAY EM XML
	public function jf_array2xml($array) {
		function array2xml($student_info, $xmlArray_student_info = null) {
			foreach($student_info as $key => $value) {
				if(is_array($value)) {
					if(!is_numeric($key)){
						$subnode = $xmlArray_student_info->addChild($key);
						array2xml($value, $subnode);
					}
					else{
						array2xml($value, $xmlArray_student_info);
					}
				}
				else {
					$xmlArray_student_info->addChild($key, $value);
				}
			}
		}

		$xmlArray_student_info = $this;
		array2xml($array, $xmlArray_student_info);		
	}
}

//funcao para converter xml em array
function xml2array ( $xmlObject, $out = array () ){
	if(!empty($xmlObject))
		foreach ( (array) $xmlObject as $index => $node )
			$out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

	if(count($out) == 1 && isset($out[0]) && count($out[0]) == 1)
		unset($out[0]);

		
	return $out;

}
?>
