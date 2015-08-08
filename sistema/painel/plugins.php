<?php
/**
*
* Plugin CMS
*
* @versão 4.0.1
* @Desenvolvedor Jeison Frasson <contato@newsmade.com.br>
* @entre em contato com o desenvolvedor <contato@newsmade.com.br> http://www.newsmade.com.br/
* @licença http://opensource.org/licenses/gpl-license.php GNU Public License
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
	  while (false!==($file=readdir($handle))) {
		 if ($file!="." && $file!="..") { 
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
		mLAviso('Houve um erro ao tentar abrir o diretório de aplicativos');
   }
?>
	<script>
		$('.install').jfbox({width: 420, height: 440});
		$('.rapido').jfbox({width: 420, height: 440});
	</script>
</div>