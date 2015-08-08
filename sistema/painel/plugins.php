<?php
/**
*
* lliure CMS
*
* @Versão 4.5.2
* @Desenvolvedor Jeison Frasson <contato@grapestudio.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

$botoes = array(
	array('href' => $backReal, 'img' => $plgIcones.'br_prev.png', 'title' => $backNome),
	array('href' => 'painel/menu-rapido.php', 'img' => $plgIcones.'lighting.png', 'title' => 'Acesso rápido', 'attr' => 'class="rapido"')
	);


echo app_bar('Painel de aplicativos', $botoes);
?>

<div id="container" >
	<?php
	
	$consulta = "select * from ".PREFIXO."plugins";
	$query = mysql_query($consulta);
	
	if(mysql_num_rows($query) > 0){
		while($dados = mysql_fetch_array($query))
		$aplicativos[$dados['pasta']] = $dados['nome'];
	}


	if ($handle=opendir("plugins")) { 
	  while (false !== ($file = readdir($handle))) {
		 if (strstr($file, '.') == false) {
			
				if(isset($aplicativos[$file])){
					?>
					<div class="listp">
						<div class="inter">
							<a href="?plugin=<?php echo $file?>"><img src="plugins/<?php echo $file?>/sys/ico.png" alt="<?php echo $file?>" /></a>
							<a href="?plugin=<?php echo $file?>"><span><?php echo $aplicativos[$file]?></span></a>
						</div>
					</div>
					<?php
				} else {
					?>
					<div class="listp">
						<div class="inter">
							<a href="painel/install.php?app=<?php echo $file?>" class="install"><img src="plugins/<?php echo $file?>/sys/ico.png" alt="<?php echo $file?>" /></a>
							<a href="painel/install.php?app=<?php echo $file?>" class="install"><span>Instalar</span></a>
						</div>
					</div>
					<?php
				}
		 }
	  }
	  closedir($handle); 
	} else {
		jfAlert('Houve um erro ao tentar abrir o diretório de aplicativos');
	}
	?>
	<script>
		$('.install').jfbox({width: 420, height: 440});
		$('.rapido').jfbox({width: 420, height: 440});
	</script>
</div>
