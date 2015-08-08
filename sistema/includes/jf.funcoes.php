<?php
/*******************************	VARIAVEIS	*/
$diasdasemana = array ("Domingo", "Segunda-Feira", "Terça-Feira","Quarta-Feira","Quinta-Feira","Sexta-Feira", "Sábado",);
$meses = array("0","Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");

//	AntiInjection
function mLAntiInjection($sql) {
	$sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$sql);
	$sql = trim($sql);
	$sql = strip_tags($sql);
	$sql = addslashes($sql);
	return $sql;
}
//	GERA MENSAGEM
function mlAviso($mensagem, $close = 1){
	$id = uniqid(time());
	return "<span id='".$id."' class='mensagem'>
				<span>$mensagem</span>
				".($close != 0?"<a href='javascript: void(0)' onclick=\"show_hide('".$id."')\" class='close'>X</a>":'')."
			</span>";
}

//	ALTERA DATA PARA UNIX			(APELIDO)
function mlDUnix($data){
	return jf_dunix($data);
}

//	funcão substr melhorada		(APELIDO)
function mLSubstr($texto, $final = 100){
	jf_substr($texto, $final);
}

function mLinsert($tabela, $dados){
	/* EXPLICANDO *********************************
	$table = "nomedatabela";
	$dados = array(
			'coluna' 	=>	'dados',
			'coluna2' 	=>	'dados2'
			);	
	$rId = é o retorno se for "1" retorna o Id incerido, caso "nulo" retorna uma string com a Query para verificações
	*/
	
	$valores = '';
	foreach($dados as $chaves => $valor){
		$valores .= (empty($valores)? "'".addslashes($valor)."'" : ", '".addslashes($valor)."'");
		(!isset($colunas)? $colunas = $chaves : $colunas = $colunas.", ".$chaves);
	}
	
	$executa = "INSERT INTO $tabela ($colunas) values ($valores)";
	$query = mysql_query($executa);
	
	global $ml_ultmo_id;
	$ml_ultmo_id = mysql_insert_id();
	
	return $executa;
}

function mLupdate($tabela, $dados, $alter, $mod = 0){

/* EXPLICANDO *********************************
$table = "nomedatabela";
$dados = array(
		'coluna' 	=>	'dados',
		'coluna2' 	=>	'dados2'
		);
		
$alter = $alter['coluna'] = "Valor";

$mod = ">" ou "<" ou "=" caso nenhum o padrão é "like"
*/

 	$valores = '';
	foreach($dados as $chaves => $valor)
		$valores .= (empty($valores)? $chaves."='".addslashes($valor)."'" : ", ".$chaves."='".addslashes($valor)."'");
	
	
	$int = array_keys($alter);
	$int = $int[0];
	$intv = $alter[$int];
	
	($mod == "0"?$mod="=": $mod="$mod");
	
	$executa = "UPDATE $tabela Set $valores where $int $mod '$intv'";
	$query = mysql_query($executa);
	
	return $executa;
}

// PARA DELETE
function mLdelete($tabela, $alter){
	
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


///////////////////////////////	Gerencia o array GET, onde retira o $needle (pode ser um array) caso exista em GET e monta em modo de link
function jf_monta_link($haystack, $needle = null, $amigavel = false){
	
	if($needle == URL_AMIGAVEL)
		$amigavel = true;	
	
	if(!is_null($needle) && $needle != URL_AMIGAVEL) {
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

////////////////////////////	Multiplos botoes submit em um form
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

function jf_roundint($val, $arredondaPor = 10){
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
	$texto = ereg_replace("[áàâãª]","a",$texto);
	$texto = ereg_replace("[éèê]","e",$texto);
	$texto = ereg_replace("[íìîï]","i",$texto);
	$texto = ereg_replace("[óòôõº]","o",$texto);
	$texto = ereg_replace("[úùû]","u",$texto);
	$texto = str_replace("ç","c",$texto);
	$texto = str_replace(" ","-",$texto);
	$texto = str_replace(array('\'','"','\\','/', '?', '%', ',', '.', ':', ';'), '', $texto);		
	return($texto);
}
?>