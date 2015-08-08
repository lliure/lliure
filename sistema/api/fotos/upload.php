<?php
require_once('../../includes/conection.php');
/*
	Link completo: upload.php?id=1*idProd&dir=../plugins*paginas_fotos

	Todos links devem ser direcionados apartir do diretório de onde está esse arquivo
	
	$_GETS	
		id[0] 	= id de onde pertence
		id[1] 	= campo que vai ser preenchido esse id
		
		dir[0] 	= diretório para onde vai ser enviado o arquivo
		dir[1] 	= nome da tabela onde vai ser gravada  				//use o PREFIXO "_fotos" se for para uma galeria/multiplo
		dir[2] 	= campo onde vai ser gravado o nome do arquivo		//opcional, o padrao é "foto"
		
		exemplo de tabela para galeria
			id, idPage, foto;
			
			onde	id 		= auto_increment;
					idPage	= preenchido por dir[1];
					foto	= nome do arquivo
*/

$all = explode("*", $_GET['dir']);

$dir = "../".$all[0];
$table = $all[1];

$campo = (empty($all[2])? 'foto': $all[2]);

$file = $_FILES["Filedata"];
$imagemNome = explode('.', $file["name"]);
$imagemNome = array_reverse($imagemNome);
$extenc = $imagemNome['0'];

$nome = md5(uniqid(time())).'.'.strtolower($extenc);	
$imagem = $dir . "/" . $nome;

$all = explode("*", $_GET['id']);

$id = $all[0];
$idCampo = (!empty($all[1])?$all[1]: "id");

$sql = "INSERT INTO ".PREFIXO.$table."_fotos (".$idCampo.", ".$campo.")
	VALUES ('".$id."', '".$nome."');";

$sql = mysql_query($sql);	

move_uploaded_file($file["tmp_name"], $imagem);

$pdt = "900";
$pdy = "500";
require_once("dimen.php");

?>