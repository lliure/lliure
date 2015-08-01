<?php
//	Efetuar login
function mLAntiInjection($sql) {
	$sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$sql);
	$sql = trim($sql);
	$sql = strip_tags($sql);
	$sql = addslashes($sql);
	return $sql;
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
	
	($mod == "0"?$mod="like": $mod="$mod");
	
	$executa = "UPDATE $tabela Set $valores where $int $mod '$intv'";
	
	$query = mysql_query($executa);
	
	return $executa;
}


function mLdelete($tabela, $alter){
	
	$int = array_keys($alter);
	$int = $int[0];
	$intv = $alter[$int];
	
	
	$executa = "DELETE FROM $tabela where $int = '$intv'";
	$query = mysql_query($executa);
	
	return $executa;
}

?>