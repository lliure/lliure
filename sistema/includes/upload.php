<?php
require_once('../../includes/conection.php');
/*
	Link completo: upload.php?id=1*idProd&dir=../plugins*paginas_fotos

	Todos links devem ser direcionados apartir do diretório de onde está esse arquivo
	
	$_GETS	
		id[0] 	= id de onde pertence
		id[1] 	= campo que vai ser preenchido esse id
		
		dir[0] 	= diretório para onde vai ser enviado o arquivo
		dir[1] 	= nome da tabela onde vai ser gravada  				//use o sufixo "_fotos" se for para uma galeria/multiplo
		dir[2] 	= campo onde vai ser gravado o nome do arquivo		//opcional, o padrao é "foto"
		
		exemplo de tabela para galeria
			id, idPage, foto;
			
			onde	id 		= auto_increment;
					idPage	= preenchido por dir[1];
					foto	= nome do arquivo
*/

$all = explode("*", $_GET['dir']);

$dir = $all[0];
$table = $all[1];

$campo = (empty($all[2])? 'foto': $all[2]);

$id = $_GET['id'];

$file = $_FILES["Filedata"];
$ex = explode('.',$file["name"]);

if(file_exists($dir) == false){
	mkdir($dir, "0777");
}

if($table != "pictures"){ 		// CASO FOR UPLOAD UNICO
	$sql = "SELECT ".$campo." FROM ".SUFIXO.$table." WHERE id = ".$id."";
	$name = mysql_fetch_array(mysql_query($sql));
	$path = $name[0];

	if(empty($nome)){
		$nome = md5(uniqid(time())).'.'.strtolower($ex[1]);	
		$path = $dir . "/" . $nome;
	}
			
	$sql = "UPDATE ".SUFIXO.$table." SET ".$campo." = '".$nome."' WHERE id = ".$id."";
			
} else {							 // CASO FOR UPLOAD DE ALBUM
		$nome = md5(uniqid(time())).'.'.strtolower($ex[1]);	
		$path = $dir . "/" . $nome;
		
		$all = explode("*", $id);
		
		$id = $all[0];
		$idCampo = (!empty($all[1])?$all[1]: "id");
		
		$sql = "INSERT INTO ".SUFIXO.$table." (".$idCampo.", ".$campo.")
			VALUES ('".$id."', '".$nome."');";
}

$sql = mysql_query($sql);
	

move_uploaded_file($file["tmp_name"], $path);

$pdt = "460";
require_once("dimen.php");
?>