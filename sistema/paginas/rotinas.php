<?php

// VERIFICA SE EXISTE ARQUIVO LLCONF.LL , SE NÃO EXISTIR CRIA UM VAZIO
if(!file_exists('../etc/llconf.ll')){
	$in = '<?xml version="1.0" encoding="iso-8859-1"?>'."\n".'<configuracoes>'."\n".'</configuracoes>';
	
	if(($fp = @fopen('../etc/llconf.ll', "w")) != false)
		fwrite($fp, $in);
		fclose($fp);
		chmod('../etc/llconf.ll', 0777); 
}

header('location: ../index.php');
?>
