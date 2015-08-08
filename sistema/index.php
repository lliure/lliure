<?php 
/**
*
* lliure WAP
*
* @Versão 4.6.2
* @Desenvolvedor Jeison Frasson <contato@grapestudio.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if(!file_exists("etc/bdconf.php"))
	header('location: install/index.php');

require_once("etc/bdconf.php"); 
require_once("includes/functions.php");

if(!isset($_SESSION['logado'])) {
	$_SESSION['ll_url'] = jf_monta_link($_GET);
	header('location: paginas/login.php');
}

if(($llconf = @simplexml_load_file('etc/llconf.ll')) == false)
	$llconf = false;

$ll_ling = ll_ling();

$pagina = "paginas/permissao.php";

$get = array_keys($_GET);
switch(isset($get[0]) ? $get[0] : 'desk' ){
	case 'plugin':
		if(!empty($_GET['plugin']) && file_exists('plugins/'.$_GET['plugin'])){
			if(ll_tsecuryt() == false){
				if(($config = @simplexml_load_file('plugins/'.$_GET['plugin'].'/sys/config.plg')) !== false && isset($config->seguranca) && $config->seguranca != 'public'){
					if(ll_securyt($_GET['plugin']) == true)
						$pagina = "plugins/".$_GET['plugin']."/start.php";
				} elseif(isset($config->seguranca) && $config->seguranca == 'public') {
					$pagina = "plugins/".$_GET['plugin']."/start.php";
				} else {
					$pagina = "plugins/".$_GET['plugin']."/start.php";
				}
			} else {
				$pagina = "plugins/".$_GET['plugin']."/start.php";
			}	
		} elseif(ll_tsecuryt('admin')) {
			$pagina = "painel/plugins.php";
		}
	break;

	case 'app':
		if(!empty($_GET['app']) && file_exists('plugins/'.$_GET['app'])){
			if(ll_tsecuryt() == false){
				if(($config = @simplexml_load_file('plugins/'.$_GET['app'].'/sys/config.plg')) !== false && isset($config->seguranca) && $config->seguranca != 'public'){
					if(ll_securyt($_GET['app']) == true)
						$pagina = "plugins/".$_GET['app']."/start.php";
				} elseif(isset($config->seguranca) && $config->seguranca == 'public') {
					$pagina = "plugins/".$_GET['app']."/start.php";
				} else {
					$pagina = "plugins/".$_GET['app']."/start.php";
				}
			} else {
				$pagina = "plugins/".$_GET['app']."/start.php";
			}	
		} elseif(ll_tsecuryt('admin')) {
			$pagina = "painel/plugins.php";
		}
	break;

	case 'minhaconta':
		$_GET['usuarios'] = $_SESSION['logado']['id'];
		$pagina = 'paginas/usuarios.php';
	break;

	case 'usuarios':
		ll_tsecuryt('admin') ? $pagina = 'paginas/usuarios.php' : '';
	break;

	case 'painel':
		ll_tsecuryt('admin') ? $pagina = 'painel/index.php' : '';
	break;

	case 'desk':
		if(isset($llconf->desktop->$_SESSION['logado']['grupo']))
			header('location: '.$llconf->desktop->$_SESSION['logado']['grupo']);
			
		$pagina = "paginas/desktop.php";
	break;

	default:
	break;
}

require_once("includes/gerenciamento_api.php"); 

ll_historico('inicia');

$plgThemer = $DadosLogado['themer']['pasta'];
$plgIcones = $DadosLogado['themer']['icones'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="SHORTCUT ICON" href="imagens/layout/favicon.ico" type="image/x-icon" />
	<meta name="author" content="Jeison Frasson" />
	<meta name="DC.creator.address" content="contato@grapestudio.com.br" />
	<meta name="DC.creator " content="Jeison Frasson" />

	<script type="text/javascript" src="api/tiny_mce/tiny_mce.js"></script>
	
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/funcoes.js"></script>
	<script type="text/javascript" src="js/jquery.jfkey.js"></script>
	<script type="text/javascript" src="js/jquery.easing.js"></script>
	<script type="text/javascript" src="js/jquery.jfbox.js"></script>
	<?php
	echo $apigem->js; 
	?>
	
	<title>lliure WAP</title>

	<link rel="stylesheet" type="text/css" href="css/base.css" />
	<link rel="stylesheet" type="text/css" href="css/principal.css" />
	<link rel="stylesheet" type="text/css" href="css/paginas.css" />
	<link rel="stylesheet" type="text/css" href="css/predifinidos.css" />
	<link rel="stylesheet" type="text/css" href="css/jfbox.css" />
	<?php
	echo $apigem->css."\r"
		.(isset($_GET['plugin']) && !empty($_GET['plugin'])  && file_exists('plugins/'.$_GET['plugin'].'/estilo.css') ?
			'<link rel="stylesheet" type="text/css" href="plugins/'.$_GET['plugin'].'/estilo.css">'
			: '' )
		.(isset($_GET['app']) && !empty($_GET['app'])  && file_exists('plugins/'.$_GET['app'].'/estilo.css') ?
			'<link rel="stylesheet" type="text/css" href="plugins/'.$_GET['app'].'/estilo.css">'
			: '' );
	?>
</head>

<body>
<div id="tudo">
	<div id="topo">
		<span class="borda-esquerda"></span>
		<span class="borda-direita"></span>
		<div class="left">
			<a href="index.php" class="logoSistema"><img src="imagens/layout/blank.gif"/></a>
			<?php
			if(!empty($_GET) &&  ll_tsecuryt()){
				$keyGet = array_keys($_GET);
				if(($keyGet['0'] == 'plugin' || $keyGet['0'] == 'app') && (!empty($_GET['plugin']) || !empty($_GET['app']))){
					?>
					<a href="javascript: void(0);" class="addDesktop" title="Adicionar essa página ao desktop"><img src="imagens/layout/add_desktop.png" alt="" /></a>
					<?php 
				}
			} 
			?>
		</div>
		

		<div class="right">			
			<div class="menu">
				<ul>
					<?php
					echo '<li><a href="index.php">Home</a></li>'
						.'<li><a href="?minhaconta">Minha conta</a></li>'
						.(ll_tsecuryt('admin') ? '<li><a href="?painel">Painel de controle</a></li>' : '')						
						.'<li><a href="acoes.php?logout">Sair</a></li>';
					?>					
				</ul>
			</div>
			<?php 
			
			if(ll_tsecuryt('admin')){
				$consulta = "select b.* from 
							".PREFIXO."start as a
							
							left join ".PREFIXO."plugins as b
							on a.idPlug = b.id
						";
				$query = mysql_query($consulta);
				
				?>
				<div class="start" id="menu_rapido"  <?php echo mysql_num_rows($query) == 0 ? 'style="display: none;"' : '' ;?>>
					<div class="width">
						<span class="icone"></span>
						<ul id="appRapido">
							<?php
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
					</div>
				</div>
				<?php				
			} 
			?>
		</div>
	</div>

	<div id="conteudo">
		<?php 	
		require_once($pagina);
		?>
		<div class="both"></div>
	</div>
</div> 

</body>

<head>
	<script type="text/javascript">
		$(function(){
			<?php
			if(isset($_SESSION['aviso'])){
				echo 'jfAlert("'.$_SESSION['aviso'][0].'", "'.(isset($_SESSION['aviso'][1]) ? $_SESSION['aviso'][1] : 1).'");';
				unset($_SESSION['aviso']);
			}
			?>
						
			$('.addDesktop').click(function(){
				ll_addDesk();
			});
	
			ll_load('load');
			ll_sessionFix();

			$('#topo .right div.start').mouseenter(function(){		
				var size = $("#appRapido").find("li").size()*52;
				$("#appRapido").css({width: size});

				$(this).stop().animate({width: size+20}, 500, 'easeInOutQuart');
			}).mouseleave(function(){
			  $(this).stop().animate({width: '20'}, 500, 'easeInOutQuart');
			});		
		});
	</script>
</head>

</html>
