<?php
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

//	ALTERA DATA PARA UNIX
function mlDUnix($data){
	$parte = explode('/', $data);
	$formata = strtotime($parte[1]."/".$parte[0]."/".$parte[2]);
	return $formata;
}

//	PREENCHE OS ZEROS A ESQUERDA
function mlPreAnt($entrada, $num){
	$tent = strlen($entrada);
	if($tent < $num){
		$fortent = $num - $tent;
		$zeros = "0";

		for($i = 1; $i < $fortent; $i++){
			$zeros .= "0";
		}
	} else {
		$zeros = "";
	}
	$entrada = $zeros.$entrada;
	return $entrada;
}

function mLinsert($tabela, $dados ,$rId = 0){
	
/* EXPLICANDO *********************************
$table = "nomedatabela";
$dados = array(
		'coluna' 	=>	'dados',
		'coluna2' 	=>	'dados2'
		);	
$rId = é o retorno se for "1" retorna o Id incerido, caso "nulo" retorna uma string com a Query para verificações
*/

	foreach($dados as $chaves => $valor){
		(!isset($valores)? $valores = "'".$valor."'" : $valores = $valores.", '".$valor."'");
		(!isset($colunas)? $colunas = $chaves : $colunas = $colunas.", ".$chaves);
	}
	
	$executa = "INSERT INTO $tabela ($colunas) values ($valores)";
	$query = mysql_query($executa);
	
	if($rId == 0){
		return $executa;
	} else {
		$ultimo_id = mysql_insert_id(); 
		return $ultimo_id;
	}
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


	foreach($dados as $chaves => $valor){
		(!isset($valores)? $valores = $chaves."='".$valor."'" : $valores = $valores.", ".$chaves."='".$valor."'");
	}
	
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
	$texto = ereg_replace("[ÓÒÔÕ]","O",$texto);
	$texto = ereg_replace("[óòôõº]","o",$texto);
	$texto = ereg_replace("[ÚÙÛ]","U",$texto);
	$texto = ereg_replace("[úùû]","u",$texto);
	$texto = str_replace("Ç","C",$texto);
	$texto = str_replace("ç","c",$texto);
	$texto = str_replace(" ","_",$texto);
	$texto = str_replace("'", "", $texto);		
	$texto = str_replace('"', "", $texto);		
	return($texto);
}


function mLmontalink($compl, $veri){
	if(is_array($veri) == false){
		unset($compl[$veri]);
	} else {
		foreach($veri as $chave => $vale){
			unset($compl[$vale]);
		}
	}
	$keys = array_keys($compl);
	
	$link = '';
	$i = 1;
	foreach($keys as $chave => $val){
		$link .= ($i != 1?"&":'').$val."=".$compl[$val];
		$i++;
	}

	return "?".$link;
}

function mLSubstr($texto, $final = 100){
	if(strlen($texto) > $final){
		$final = strrpos(substr($texto, 0, $final), " ");
		$texto = substr(strip_tags($texto), 0 , $final)." ...";
	} 
	return $texto;
}

?>