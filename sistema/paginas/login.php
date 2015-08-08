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

require_once('../etc/bdconf.php');
require_once('../includes/jf.funcoes.php');

if(isset($_SESSION['logado'])){
	
	header('location: rotinas.php');
	
} elseif(!empty($_POST)){
	require_once('../includes/jf.funcoes.php');
	
	// CONFIGURA O THEMER NO SISTEMA
	function plg_themer($thema){
		$caminho = '../themer/'.(empty($thema) ? 'default' : $thema);
		
		if(file_exists($caminho.'/padrao.txt'))
			$fp = fopen($caminho.'/padrao.txt', 'r');
		else
			$fp = fopen('../themer/default/padrao.txt', 'r');	
		
		while (!feof($fp)){
			$linha = fgets($fp);
			$linha = explode('=', $linha);
			
			$plg_themer[trim($linha[0])] = trim($linha[1]);
		}
		fclose($fp);
		
		return $plg_themer;
	}
	
	
	$falha = false;
	if( (!empty($_POST['usuario'])) && (!empty($_POST['senha'])) && jf_token($_POST['token'])){	
		$senha = md5($_POST['senha']."0800");
		$usuario = jf_anti_injection($_POST['usuario']);		
		
		$dadosUser = mysql_query("SELECT * FROM ".PREFIXO."admin WHERE Login = '".$usuario."' AND Senha = '".$senha."' limit 1");
		
		if(mysql_num_rows($dadosUser) > 0){
			$dadosUser = mysql_fetch_assoc($dadosUser);
			
			$_SESSION['logado'] = array(
				'id' => $dadosUser['id'],
				'nome' => $dadosUser['nome'],
				'tipo' => $dadosUser['grupo'], // será depreciado
				'grupo' => $dadosUser['grupo'],
				'themer' => 'default'
				);
		} else {
			$falha = true;
		}
	
			
		if($falha == false){
			// define os padroes do tema
			$tema = $_SESSION['logado']['themer'];
			$_SESSION['logado']['themer'] = plg_themer($_SESSION['logado']['themer']);
			$_SESSION['logado']['themer']['pasta'] = $tema;
		}
	} else {
		$falha = true;
	}
	
	if($falha == false)
		header('location: rotinas.php');
}
?>

<html>
<head>
	<style type="text/css" media="screen">
			@import "../css/base.css";
			@import "../css/login.css";
	</style>
	
	<script type="text/javascript" src="../js/jquery.js"></script>
	
	<title>lliure Web Application Platform</title>
</head>

<body>
<div id="login">
	<img src="../imagens/layout/logo.png" class="logo" alt="Plugin" />
	<?php
	if(isset($falha))
		echo '<span class="mensagem">Login e/ou senha incorreto(s). Tente novamente</span>';
	
	$_SESSION['token'] = uniqid(md5(time()));
	jf_token('novo');
	?>
	
	<div id="loginBox">
		<form method="post" action="login.php" id="form">
			<input type="hidden" name="token" value="<?php echo jf_token('exibe'); ?>">
			<fieldset>
				<div>
					<label>Usuário</label>
					<input type="text" name="usuario" class="user" autocomplete="off" />
				</div>	
				
				<div>
					<label>Senha</label>
					<input type="password" name="senha" />
				</div>
			</fieldset>
			<span class="botao"><button type="submit">Entrar</button></span>
		</form>
		<div class="both"></div>
	</div>
</div>	

</body>

<head>
	<script type="text/javascript">
	$(document).ready(function(){
		$('.user').focus();

		<?php
		if(isset($falha)){
			?>
			var tempo = 150;
			var left = -50;
			var right = 50;
			

			$('#loginBox').animate({
				left: right+"px"
				},tempo, function() {
					$(this).animate({
						left: left+"px"
						},tempo, function() {
						  $(this).animate({
								left: right+"px"
								},tempo-50, function() {
									$(this).animate({
										left: left+"px"
										},tempo-50, function() {
											$(this).animate({
												left: "0px"
												},tempo-50)
											})
									})
						})
			});
			<?php
		}
		?>
	});
	</script>
</head>
</html>
