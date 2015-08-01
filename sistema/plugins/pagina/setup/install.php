<span class="opn">Estrutura da tabela <?=$sufix?>paginas</span>
<?php
$sql = "CREATE TABLE IF NOT EXISTS `".$sufix."paginas` (
			`id` int(11) NOT NULL auto_increment,
			`nome` varchar(15) NOT NULL,
			`titulo` varchar(200) default NULL,
			`conteudo` text,
			PRIMARY KEY  (`id`)
			)"; 
			
$resultado = mysql_query($sql) or die (mysql_error()); 
?>

<span class="ok">Tabela de <?=$sufix?>paginas criada com sucesso!</span>

