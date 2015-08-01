<?php
	
	$dados['nome'] = "Formulário";
	
	if(isset($_GET['id'])){
		$dados['id'] = $_GET['id'];
	}	
	
	$idNew = mLinsert($pluginTable, $dados, 1);
	
	$sql = "INSERT INTO ".$pluginTable."_campos (id_form,identificacao,titulo,tipo,ordem) VALUES ('".$idNew."','nome','Nome','text','1')";
	mysql_query($sql);
	
	$sql = "INSERT INTO ".$pluginTable."_campos (id_form,identificacao,titulo,tipo,ordem) VALUES ('".$idNew."','email','E-mail','text','2')";
	mysql_query($sql);
	
	$sql = "INSERT INTO ".$pluginTable."_campos (id_form,identificacao,titulo,tipo,ordem) VALUES ('".$idNew."','telefone','Telefone','text','3')";
	mysql_query($sql);
	
	$sql = "INSERT INTO ".$pluginTable."_campos (id_form,identificacao,titulo,tipo,ordem) VALUES ('".$idNew."','mensagem','Mensagem','textarea','4')";
	mysql_query($sql);
	
	echo mensagemAviso("Novo formulário criado com sucesso.");
	
	require_once("home.php");
?>