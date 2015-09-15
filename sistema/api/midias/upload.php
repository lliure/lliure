<?php

/* @var $midias Midias */
header ('Content-type: text/html; charset=ISO-8859-1'); require_once 'header.php';

$e = explode('.', $_FILES['file']['name']);
$ets = array_pop($e);
$nam = implode('.', $e);
$i = -1;
$file = $midias->pasta(). DS. $_FILES['file']['name'];
while (file_exists(($file = $midias->pasta(). DS. ($name = ($nam. ((++$i) > 0? '('. $i. ')': ''). '.'. $ets)))));

$erros = array(
	0 => 'N�o houve erro, o upload foi bem sucedido.',
	1 => 'O arquivo no upload � maior do que o limite definido em upload_max_filesize no php.ini.',
	2 => 'O arquivo ultrapassa o limite de tamanho em MAX_FILE_SIZE que foi especificado no formul�rio HTML.',
	3 => 'O upload do arquivo foi feito parcialmente.',
	4 => 'N�o foi feito o upload do arquivo.'
);

$t = move_uploaded_file($_FILES['file']['tmp_name'], $file);

if ($t !== FALSE){
	
	$data = filemtime($file);
	$size = filesize($file);
	
	echo json_encode(Midias::preparaParaJson(array(
		'data' => $data,
		'size' => $size,
		'etc'  => $ets,
		'nome' => $name
	)));
	
}else {
	echo json_encode(Midias::preparaParaJson(array(
		'erro' => !$t,
		'cod' => $_FILES['file']['error'],
		'msg' => $erros[$_FILES['file']['error']]
	)));
}
