<?php 
/**
*
* Plugin CMS
*
* @versão 4.2.7
* @Desenvolvedor Jeison Frasson <contato@newsmade.com.br>
* @entre em contato com o desenvolvedor <contato@newsmade.com.br> http://www.newsmade.com.br/
* @licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if(!file_exists("includes/conection.php")) 
	header('location: install/index.php');

require_once("includes/conection.php"); 

if(!isset($_SESSION['logado']))
	header('location: paginas/login.php');
	
require_once("includes/functions.php"); 
require_once("includes/gerenciamento_api.php"); 

navig_historic();

$plgThemer = $DadosLogado['themer']['pasta'];
$plgIcones = $DadosLogado['themer']['icones'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="SHORTCUT ICON" href="imagens/layout/favicon.ico" type="image/x-icon" />
	<meta name="author" content="Jeison Frasson" />
	<meta name="DC.creator.address" content="contato@newsmade.com.br" />
	<meta name="DC.creator " content="Jeison Frasson" />

	<script type="text/javascript" src="api/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="api/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
	
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/funcoes.js"></script>
	<script type="text/javascript" src="js/jquery.jfkey.js"></script>
	<script type="text/javascript" src="js/jquery.jfbox.js"></script>
	
	<script type="text/javascript" src="js/jquery.maskedinput-1.2.2.js"></script>
	<?php
	echo $apigem->js; 
	?>
	
	<title>sistema Plugin</title>

	<style type="text/css" media="screen">
		@import "css/base.css";
		@import "css/principal.css";
		@import "css/paginas.css";
		@import "css/predifinidos.css";
		@import "css/jfbox.css";
		<?php
		echo $apigem->css."\r"
			.(isset($_GET['plugin']) && !empty($_GET['plugin'])  && file_exists('plugins/'.$_GET['plugin'].'/estilo.css') ?  '@import "plugins/'.$_GET['plugin'].'/estilo.css"; ' : '' );
		?>
		
		#topo{
			background: url("<?php echo 'themer/'.$plgThemer.'/bg.jpg'?>") center top repeat-x;
		}
	</style>
</head>


<body>
<div id="tudo">
	<div id="topo">
		<div class="left">
			<a href="index.php" class="logoSistema"><img src="<?php echo 'themer/'.$plgThemer.'/logo.png'?>"/></a>
			<?php
			if(!empty($_GET)){
				$keyGet = array_keys($_GET);
				if($keyGet['0'] == 'plugin' and  !empty($_GET['plugin'])){
					?>
					<a href="javascript: void(0);" class="addDesktop" title="Adicionar essa página ao desktop"><img src="imagens/layout/add_desktop.png" alt="" /></a>
					<?php 
				}
			} 
			?>
		</div>
		
		<?php
		if(!empty($DadosLogado)){ ?>
		<div class="right">
			<ul class="menu">
				<li><a href="index.php">Home</a></li>
				<li><a href="?usuarios">Usuários</a></li>
			<?php
			if($DadosLogado['tipo'] == 1){ 
				?>
				<li><a href="?plugin">Aplicativos</a></li>
				<?php
			}
			?>
				<li><a href="acoes.php?logout">Sair</a></li>
			</ul>
			<?php 
			
			if($DadosLogado['tipo'] == 1){
				?>
				<ul class="start" id="appRapido">
				<?php
					$consulta = "select b.* from 
						".PREFIXO."start as a
						
						left join ".PREFIXO."plugins as b
						on a.idPlug = b.id
					";
					$query = mysql_query($consulta);

					while($dados = mysql_fetch_array($query)){
					?>
					<li id="appR-<?php echo $dados['id']?>">
						<a href="?plugin=<?php echo $dados['pasta']?>" title="<?php echo $dados['nome']?>">
							<img src="plugins/<?php echo $dados['pasta']?>/sys/ico.png" alt="" />
						</a>
					</li>
					<?php
					}
					?>
				</ul>
				<?php
			} 
		?>
		</div>
		<?php	
		}
		?>
	</div>

	<div id="conteudo">
		<?php 	
		if(!empty($DadosLogado)){
			if(isset($_GET['plugin'])){
				if(!empty($_GET['plugin'])){
					$pagina = "plugins/".$_GET['plugin']."/start.php";
				} else {
					$pagina = "painel/plugins.php";
				}
			} elseif(isset($_GET['usuarios'])) {
				$pagina = "paginas/usuarios.php";
			} else {
				$pagina = "paginas/desktop.php";
			}
		} else {
			$pagina = "paginas/login.php";
		}

		require_once($pagina);
		?>
		<div class="both"></div>
	</div>
	
	<div id="rodape">
		<span class="desenvolvidopor">
			<a href="http://www.newsmade.com.br">Desenvolvido por Jeison Frasson</a>
		</span>
	</div>
</div> 

</body>

<head>
	<script type="text/javascript">
		$(function(){
			<?php
			if(isset($_SESSION['aviso'])){
				echo 'jfAlert("'.$_SESSION['aviso'][0].'", "'.$_SESSION['aviso'][1].'");';
				unset($_SESSION['aviso']);
			}
			?>
			
			$('.addDesktop').click(function(){
				plg_addDesk();
			});
	
			plg_sessionFix();
			plg_load('load');
		});
	</script>
</head>

</html>