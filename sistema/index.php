<?php 
/**
*
* lliure WAP
*
* @Versão 4.10.4
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/


if(!file_exists("etc/bdconf.php"))
	header('location: install/index.php');

require_once("etc/bdconf.php"); 
require_once("includes/functions.php");


// Identifica o diretório atual do sistema
ll_dir();

if(!isset($_SESSION['logado'])) {
	$_SESSION['ll_url'] = jf_monta_link($_GET);
	header('location: paginas/login.php');
}

$_ll['user'] = $_SESSION['logado'];

$_ll['css'] = array();
$_ll['js'] = array();

if(($_ll['conf'] = @simplexml_load_file('etc/llconf.ll')) == false)
	$_ll['conf'] = false;

$llconf = $_ll['conf'];

$_ll['ling'] = ll_ling();
$ll_ling = $_ll['ling'];

require_once("api/gerenciamento_de_api.php"); 

$_ll['app']['header'] = null;
$_ll['app']['pagina'] = "paginas/permissao.php";

$get = array_keys($_GET);
switch(isset($get[0]) ? $get[0] : 'desk' ){
	case 'app':
		if(!empty($_GET['app']) && file_exists('plugins/'.$_GET['app'])){
			$llAppHome = 'index.php?app='.$_GET['app'];
			$llAppOnServer = 'onserver.php?app='.$_GET['app'];
			$llAppPasta = 'plugins/'.$_GET['app'].'/';
			
			$ll_segok = false;
			
			if(ll_tsecuryt() == false){
				$arquivo_config = 'plugins/'.$_GET['app'].'/sys/config.ll';
				
				/*** para compatibilidade { */
				if(file_exists('plugins/'.$_GET['app'].'/sys/config.plg'))
					$arquivo_config = 'plugins/'.$_GET['app'].'/sys/config.plg';
				/*** } */
				
				if(($config = @simplexml_load_file($arquivo_config)) !== false){
					
					if($config->seguranca != 'public' && (ll_securyt($_GET['app']) == true))
						$ll_segok = true;
					elseif($config->seguranca == 'public')
						$ll_segok = true;

				} else {
					$ll_segok = true;
				}
			} else {
				$ll_segok = true;
			}	
			
			if($ll_segok){
				$_ll['app']['pagina'] = 'plugins/'.$_GET['app'].'/start.php';
				$_ll['app']['pasta'] = 'plugins/'.$_GET['app'].'/';
				
				if(file_exists('plugins/'.$_GET['app'].'/header.php'))
					$_ll['app']['header'] = 'plugins/'.$_GET['app'].'/header.php';			
			}
			
		} elseif(ll_tsecuryt('admin')) {
			$_ll['app']['pagina'] = "painel/plugins.php";
		}
		break;

	case 'minhaconta':
		$_GET['usuarios'] = $_SESSION['logado']['id'];
		$_ll['css'][] = 'css/usuarios.css';
		
		$_ll['app']['header'] = 'paginas/usuarios.header.php';
		$_ll['app']['pagina'] = 'paginas/usuarios.php';
		break;

	case 'usuarios':
		if(ll_tsecuryt('admin')){
			$_ll['app']['pagina'] = 'paginas/usuarios.php';
			$_ll['app']['header'] = 'paginas/usuarios.header.php';
			
			$_ll['css'][] = 'css/usuarios.css';
		}
		break;

	case 'painel':
		ll_tsecuryt('admin') ? $_ll['app']['pagina'] = 'painel/index.php' : '';
		break;

	case 'desk':
		if(isset($llconf->desktop->$_SESSION['logado']['grupo']))
			header('location: '.$llconf->desktop->$_SESSION['logado']['grupo']);
			
		$_ll['app']['pagina'] = "paginas/desktop.php";
		$_ll['app']['header'] = 'paginas/desktop.header.php';
		break;

	default:
		break;
}

/****/

lliure::loadJs('js/jquery.js');
lliure::loadJs('api/tiny_mce/tiny_mce.js');
lliure::loadJs('js/jquery-ui.js');
lliure::loadJs('js/funcoes.js');
lliure::loadJs('js/jquery.jfkey.js');
lliure::loadJs('js/jquery.easing.js');
lliure::loadJs('js/jquery.jfbox.js');

lliure::loadCss('css/base.css');
lliure::loadCss('css/principal.css');
lliure::loadCss('css/paginas.css');
lliure::loadCss('css/predifinidos.css');
lliure::loadCss('css/jfbox.css');

$apigem = new api; 
$apigem->iniciaApi('appbar');
$apigem->iniciaApi('fileup');

if($_ll['app']['header'] != null)
	require_once($_ll['app']['header']);

//Inicia o histórico
ll_historico('inicia');

//Inicia o Tema atual 	
if(($ll_tema = @simplexml_load_file('temas/'.$_ll['user']['tema'].'/dados.ll'))){
	$_ll['tema'] = (array) $ll_tema;
	$ll_icones = $_ll['tema']['icones'];
	$plgIcones = $ll_icones;
}
// 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="SHORTCUT ICON" href="imagens/layout/favicon.ico" type="image/x-icon" />
	<meta name="author" content="Jeison Frasson" />
	<meta name="DC.creator.address" content="jomadee@lliure.com.br" />
	<meta name="DC.creator " content="Jeison Frasson" />


	
	<?php
	lliure::loadCss();
	
	
	echo (isset($_GET['app']) && !empty($_GET['app'])  && file_exists('plugins/'.$_GET['app'].'/estilo.css') ?
		'<link rel="stylesheet" type="text/css" href="plugins/'.$_GET['app'].'/estilo.css">'
		: '' )

	.'<link rel="stylesheet" type="text/css" href="temas/'.$ll_tema->id.'/estilo.css">';
	
	
	lliure::loadJs();
	?>
	

	<?php
	
	?>
	<title>lliure WAP</title>
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
							on a.idPlug = b.id	";
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
									<a href="?app=<?php echo $dados['pasta']?>" title="<?php echo $dados['nome']?>">
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
		require_once($_ll['app']['pagina']);
		?>
		<div class="both"></div>
	</div>
	
	
	<div id="rodape">
		<a href="http://www.lliure.com.br"><img src="imagens/layout/logo_inf.png" alt="" /></a>
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
