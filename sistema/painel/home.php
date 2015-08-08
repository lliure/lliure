<?php
/**
*
* lliure WAP
*
* @Versão 4.9.1
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

ll_historico('reinicia');

$botoes = array(
	array('href' => $backReal, 'img' => $plgIcones.'br_prev.png', 'title' => $backNome)
	);

echo app_bar('Painel de controle', $botoes);
?>

<div class="painelCtrl">
	<div class="bloco">
		<h2>Configurações</h2>
		
		<?php
		if(ll_tsecuryt()) {
			?>
			<div class="listp">
				<div class="inter link_idioma">
					<a href="painel/idiomas.php"><img src="imagens/layout/language.png" alt="" /></a>
					<a href="painel/idiomas.php"><span>Idiomas</span></a>
				</div>
			</div>
			<?php
		}
		?>
		<div class="listp">
			<div class="inter">
				<a href="paginas/sobre.php" class="llSobre"><img src="imagens/layout/info.png" alt="" /></a>
				<a href="paginas/sobre.php" class="llSobre"><span>Sobre</span></a>
			</div>
		</div>	
		
		<div class="listp">
			<div class="inter menu_rapido">
				<a href="painel/menu-rapido.php"><img src="imagens/layout/menu_rapido.png" alt="" /></a>
				<a href="painel/menu-rapido.php"><span>Acesso rápido</span></a>
			</div>
		</div>
		
		<div class="listp">
			<div class="inter">
				<a href="?usuarios"><img src="imagens/layout/users.png" alt="" /></a>
				<a href="?usuarios"><span>Usuários</span></a>
			</div>
		</div>		
			
	</div>
	
	<div class="bloco">
		<h2>Aplicativos</h2>
		<?php
		$appFolder = array();
		$erroAbrirDir = false;
		$consulta = "select * from ".PREFIXO."plugins";
		$query = mysql_query($consulta);
		
		if(mysql_num_rows($query) > 0)
			while($dados = mysql_fetch_array($query))
			$aplicativos[$dados['pasta']] = $dados['nome'];

		if ($handle=opendir("plugins")) {
			while (false !== ($file = readdir($handle))) 
				if (strstr($file, '.') == false) 
						$appFolder[] = $file;
			 
			closedir($handle);
		} else {
			$erroAbrirDir = true;
		}		
		
		natcasesort($appFolder);
		
		if($erroAbrirDir == false) {
			foreach($appFolder as $chave => $file){
				if(isset($aplicativos[$file])){
					?>
					<div class="listp">
						<div class="inter">
							<a href="?app=<?php echo $file?>"><img src="plugins/<?php echo $file?>/sys/ico.png" alt="<?php echo $file?>" /></a>
							<a href="?app=<?php echo $file?>"><span><?php echo $aplicativos[$file]?></span></a>
						</div>
					</div>
					<?php
				} elseif(ll_tsecuryt()) {
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
		} else {
			echo '<script type="text/javascript"> jfAlert("Houve um erro ao tentar abrir o diretório de aplicativos") </script>';			
		}
		?>
	</div>
</div>

<script type="text/javascript">
	$('.menu_rapido a, .install').jfbox({width: 420, height: 440});
	
	$('.link_idioma a').jfbox({width: 420, height: 440, addClass: 'idiomaBox'});
	
	$('.llSobre').jfbox({width: 420, height: 200, addClass: 'llSobre_box'});
</script>
