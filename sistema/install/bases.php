<h2>Instalando bases primarias</h2>

<?php
$sufix = SUFIXO;

$sql = "SHOW TABLES FROM $banco_conexao";
$result = mysql_query($sql);

$table = array();
while ($row = mysql_fetch_row($result)) {
	$table[] = $row[0];
}
if(in_array(SUFIXO.'admin', $table) == false){
	?>
	<span class="opn">Estrutura da tabela <?php echo $sufix?>admin</span>
	<?php

	$sql = "CREATE TABLE IF NOT EXISTS `{$sufix}admin` (
			  `id` int(11) NOT NULL auto_increment,
			  `login` varchar(200) NOT NULL,
			  `senha` varchar(200) NOT NULL,
			  `nome` varchar(200) NOT NULL,
			  `tipo` enum('0','1') NOT NULL,
			  PRIMARY KEY  (`id`)		
			)"; 
				
	$resultado = mysql_query($sql) or die (mysql_error()); 
	?>
	<span class="ok">Tabela de <?php echo $sufix?>admin criada com sucesso!</span>

	<span class="opn">Adcionando dados da tabela<?php echo $sufix?>admin</span>
	<?php
		$sql = "INSERT INTO {$sufix}admin (login, senha, nome, tipo) VALUES 
					('admin', 'f28a1f857929059261bb4331c00a2abe', 'Jeison Frasson', '1')	
						";
						
		$resultado = mysql_query($sql) or die (mysql_error()); 
	?>
	----------------------------------------------------------
	<?php
} else {
	?>
	<span class="err">A tabela tabela<?php echo $sufix?>admin já existe e não pode ser criada novamente!</span>
	<?php
}

if(in_array(SUFIXO.'plugins', $table) == false){
	?>
	<span class="opn">Estrutura da tabela <?php echo $sufix?>plugins</span>
	<?php

	$sql = "CREATE TABLE IF NOT EXISTS `{$sufix}plugins` (
					`id` int(11) NOT NULL auto_increment,
					`nome` varchar(200) NOT NULL,
					`pasta` varchar(100) NOT NULL,
					PRIMARY KEY  (`id`),
					UNIQUE KEY `pasta` (`pasta`)
					)"; 
				
	$resultado = mysql_query($sql) or die (mysql_error()); 
	?>

	<span class="ok">Tabela de <?php echo $sufix?>plugins criada com sucesso!</span>
	----------------------------------------------------------
	<?php
}else {
	?>
	<span class="err">A tabela tabela<?php echo $sufix?>plugins já existe e não pode ser criada novamente!</span>
	<?php
}

if(in_array(SUFIXO.'start', $table) == false){
	?>
	<span class="opn">Estrutura da tabela <?php echo $sufix?>start</span>
	<?php

	$sql = "CREATE TABLE IF NOT EXISTS  `{$sufix}start` (
					`idPlug` int(11) NOT NULL,
					PRIMARY KEY  (`idPlug`)
					)"; 
				
	$resultado = mysql_query($sql) or die (mysql_error()); 
	?>

	<span class="ok">Tabela de <?php echo $sufix?>start criada com sucesso!</span>

	----------------------------------------------------------
	<?php
} else {
	?>
	<span class="err">A tabela tabela<?php echo $sufix?>start já existe e não pode ser criada novamente!</span>
	<?php
}

if(in_array(SUFIXO.'desktop', $table) == false){
	?>
	<span class="opn">Estrutura da tabela <?php echo $sufix?>desktop</span>
	<?php

	$sql = "CREATE TABLE IF NOT EXISTS  `".$sufix."desktop` (
				`id` int(11) NOT NULL auto_increment,
				`nome` varchar(30) NOT NULL,
				`link` varchar(200) NOT NULL,
				`imagem` varchar(200) NOT NULL,
				PRIMARY KEY  (`id`)
				)"; 
				
	$resultado = mysql_query($sql) or die (mysql_error()); 
	?>

	<span class="ok">Tabela de <?php echo $sufix?>desktop criada com sucesso!</span>
	---------------------------------------------------------- <br/>
	<?php
} else {
	?>
	<span class="err">A tabela tabela<?php echo $sufix?>desktop já existe e não pode ser criada novamente!</span>
	<?php
}
?>
<div class="both"></div>
<a href="?passo=plugin">Instalar plugins</a>