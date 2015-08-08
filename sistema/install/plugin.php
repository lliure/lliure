<h2>Instalação de plugins</h2>
<?php
if(!empty($_POST)){
	foreach($_POST['plug'] as $chave => $valor){
		?>
		<div class="plugInt">
			<?php
			require_once($valor."/sys/install.php");
			?>
			<h4>Instalando plugin <?php echo $pluginName?></h4>
			<?php
			if(mysql_query($pluginSql)){
				?>
				<span class="ok">A base de dados do plugin <strong><?php echo $pluginName?></strong> foi criada com sucesso!</span>
				<?php
				
				$sql = 'INSERT INTO `'.SUFIXO.'plugins` (`nome`, `pasta`) VALUES (\''.$pluginName.'\', \''.$pluginPasta.'\');'; 
				if(mysql_query($sql)){
					?>
					<span class="ok">Plugin <strong><?php echo $pluginName?></strong> adicionado a lista de plugins!</span>
					<?php
				} else{
					?>
					<span class="err">O plugin <strong><?php echo $pluginName?></strong> já está adicionado a sua lista de plugins</span>
					<?php
				}
			} else{
				?>
				<span class="err">Houve um erro ao criar as bases do plugin <strong><?php echo $pluginName?></strong></span>
				<?php
			}
			?>
		</div>
		<?php
	}
	?>
	<span class="ok"><strong>Todos plugins selecionados foram instalados com sucesso!</strong></span>
	<a href="../index.php">Ir para página home</a>
	<a href="?passo=plugin">Instalar outros plugins</a>
	<?php
} else {
?>
<form method="post">
<?php
$dir = "../plugins";
$arquivos = opendir($dir);

while (false !== ($filename = readdir($arquivos))) {
	if(file_exists($dir."/".$filename."/sys/install.php")){
		$caminho = $dir."/".$filename;
		?>
			<div class="tMenu">
				<input type="checkbox" name="plug[]" value="<?php echo $caminho?>"><img src="<?php echo $caminho?>/sys/ico.png" /> <?php echo $filename?>
			</div>
		<?php
	}
}	
?>
<a href="?passo=bases">voltar</a>
<button type="submit">Instalar selecionados</button>
</form>

<?php
}
?>