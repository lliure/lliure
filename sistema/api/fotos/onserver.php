<?php

/*
if (!empty($_FILES)) {	
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
	
	$dados = explode('*', $_GET['array']);
	// 0:tabela; 1:campo ; 2:fk id
	
	// Trata nome do arquivo

	$nome = explode('.', iconv('UTF-8', 'ISO-8859-1', $_FILES['Filedata']['name']));
	$ext = array_pop($nome);
	
	$nome_limpo = implode('_', $nome);
	$nome = jf_urlformat(substr($nome_limpo, 0, 12).'_'.substr(uniqid(md5(time()), true), -5)).'.'.strtolower($ext);
	
	$targetFile =  str_replace('//','/',$targetPath) . $nome ;
	jf_insert(PREFIXO.$dados[0], array('foto' => $nome, $dados[1] => $dados[2]));
	if(move_uploaded_file($_FILES['Filedata']['tmp_name'], $targetFile) != false){
		jf_insert(PREFIXO.$dados[0], array('foto' => $nome, $dados[1] => $dados[2]));
	
		echo $nome;
	}
}*/
?>